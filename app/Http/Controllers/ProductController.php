<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\StockMovement;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $products = Product::latest()
        ->paginate(20);

    return view(
        'products.index',
        compact('products')
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $warehouses = Warehouse::all();

        return view('products.create', compact('categories','warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'sku' => 'required|unique:products,sku',
        'quantity' => 'required|integer|min:0',
        'purchase_price' => 'required|numeric',
        'sale_price' => 'required|numeric',
    ]);

    Product::create([

        'name' => $request->name,

        'sku' => $request->sku,

        'quantity' => $request->quantity,

        'purchase_price' =>
            $request->purchase_price,

        'sale_price' =>
            $request->sale_price,

        'is_active' =>
            $request->has('is_active'),
        'category_id' =>
    $request->category_id,
    'warehouse_id' => $request->warehouse_id,
'low_stock' => $request->low_stock ?? 5,
    ]);

    return redirect()
        ->route('products.index')
        ->with(
            'success',
            'Product Created Successfully'
        );
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
{
    $product->load(['category','warehouse']);

    return view('products.show', compact('product'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $warehouses = Warehouse::all();
    
        return view('products.edit', compact(
            'product',
            'categories',
            'warehouses'
        ));
    }

public function update(Request $request, Product $product)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required',
        'sku' => 'required|unique:products,sku,' . $product->id,
        'quantity' => 'required|integer',
        'purchase_price' => 'required',
        'sale_price' => 'required',
        'warehouse_id' => 'nullable|exists:warehouses,id',
'low_stock' => 'nullable|integer|min:0',
    ]);

    $product->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'sku' => $request->sku,
        'quantity' => $request->quantity,
        'purchase_price' => $request->purchase_price,
        'sale_price' => $request->sale_price,
        'is_active' => $request->has('is_active'),
    ]);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product Updated Successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()
            ->route('products.index')
            ->with('success', 'Product Deleted Successfully');
    }
    public function addStock(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $product->increment('quantity', $request->quantity);

    StockMovement::create([
        'product_id' => $product->id,
        'type' => 'in',
        'quantity' => $request->quantity,
        'user_id' => auth()->id(),
    ]);

    return back()->with('success','Stock added');
}
public function sellStock(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    if ($product->quantity < $request->quantity) {
        return back()->with('error','Not enough stock');
    }

    $product->decrement('quantity', $request->quantity);

    StockMovement::create([
        'product_id' => $product->id,
        'type' => 'out',
        'quantity' => $request->quantity,
        'user_id' => auth()->id(),
    ]);

    return back()->with('success','Stock sold');
}
}
