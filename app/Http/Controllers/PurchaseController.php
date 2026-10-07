<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\StockMovement;
use App\Services\AccountingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with([
            'supplier',
            'product',
            'warehouse',
        ])
        ->latest()
        ->paginate(20);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('purchases.create', [
            'suppliers'  => Supplier::all(),
            'products'   => Product::all(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function store(Request $request, AccountingService $accounting)
    {
        $data = $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'product_id'    => 'required|exists:products,id',
            'warehouse_id'  => 'required|exists:warehouses,id',
            'quantity'      => 'required|integer|min:1|max:1000000',
            'unit_price'    => 'required|numeric|min:0|max:999999999',
            'purchase_date' => 'required|date',
            'notes'         => 'nullable|string|max:1000',
        ]);

        try {
            DB::transaction(function () use ($data, $accounting) {

                $acc = $accounting->accounts(['1100', '1000']);

                $total = round($data['quantity'] * $data['unit_price'], 2);

                $purchase = Purchase::create($data + ['total' => $total]);

                Product::whereKey($data['product_id'])
                    ->increment('quantity', $data['quantity']);

                StockMovement::create([
                    'product_id'   => $data['product_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'user_id'      => auth()->id(),
                    'type'         => 'in',
                    'quantity'     => $data['quantity'],
                    'note'         => 'Purchase #' . $purchase->id,
                ]);

                // ONE journal entry only (it used to be posted twice)
                $accounting->createEntry(
                    'Purchase #' . $purchase->id,
                    auth()->id(),
                    [
                        ['account_id' => $acc['1100']->id, 'debit'  => $total],
                        ['account_id' => $acc['1000']->id, 'credit' => $total],
                    ]
                );
            });
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase Created Successfully');
    }
}
