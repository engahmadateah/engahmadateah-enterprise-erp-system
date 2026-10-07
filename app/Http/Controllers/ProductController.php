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
        'sku' => 'required|string|max:100|unique:products,sku',
        'quantity' => 'required|integer|min:0|max:100000000',
        'purchase_price' => 'required|numeric|min:0|max:999999999',
        'sale_price' => 'required|numeric|min:0|max:999999999',
        'warehouse_id' => 'nullable|exists:warehouses,id',
        'low_stock' => 'nullable|integer|min:0',
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
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
        'quantity' => 'required|integer|min:0|max:100000000',
        'purchase_price' => 'required|numeric|min:0|max:999999999',
        'sale_price' => 'required|numeric|min:0|max:999999999',
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
        'warehouse_id' => $request->warehouse_id,
        'low_stock' => $request->low_stock ?? $product->low_stock,
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
        'quantity' => 'required|integer|min:1|max:1000000'
    ]);

    \Illuminate\Support\Facades\DB::transaction(function () use ($request, $product) {
        $product->increment('quantity', $request->quantity);

        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
        ]);
    });

    return back()->with('success','Stock added');
}
public function sellStock(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1|max:1000000'
    ]);

    // lock the row: two parallel requests must not drive stock negative
    $ok = \Illuminate\Support\Facades\DB::transaction(function () use ($request, $product) {
        $locked = Product::lockForUpdate()->findOrFail($product->id);

        if ($locked->quantity < $request->quantity) {
            return false;
        }

        $locked->decrement('quantity', $request->quantity);

        StockMovement::create([
            'product_id' => $locked->id,
            'type' => 'out',
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
        ]);

        return true;
    });

    if (! $ok) {
        return back()->with('error','Not enough stock');
    }

    return back()->with('success','Stock sold');
}
}
