<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Warehouse;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use App\Services\AccountingService;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with([
            'supplier',
            'product',
            'warehouse'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'purchases.index',
            compact('purchases')
        );

    }

    public function create()
    {
        $suppliers = Supplier::all();

        $products = Product::all();

        $warehouses = Warehouse::all();

        return view(
            'purchases.create',
            compact(
                'suppliers',
                'products',
                'warehouses'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'supplier_id' => 'required',

            'product_id' => 'required',

            'warehouse_id' => 'required',

            'quantity' => 'required|integer|min:1',

            'unit_price' => 'required|numeric',

            'purchase_date' => 'required',

        ]);

        $total =
            $request->quantity
            *
            $request->unit_price;

        $purchase = Purchase::create([

            'supplier_id' =>
                $request->supplier_id,

            'product_id' =>
                $request->product_id,

            'warehouse_id' =>
                $request->warehouse_id,

            'quantity' =>
                $request->quantity,

            'unit_price' =>
                $request->unit_price,

            'total' =>
                $total,

            'purchase_date' =>
                $request->purchase_date,

            'notes' =>
                $request->notes,

        ]);

        $inventoryAccount = Account::where(
            'code',
            '1100'
        )->first();
        
        $cashAccount = Account::where(
            'code',
            '1000'
        )->first();
        
        $entry = JournalEntry::create([
        
            'entry_number' =>
                'JE-' . date('YmdHis'),
        
            'entry_date' =>
                now(),
        
            'description' =>
                'Purchase #'.$purchase->id,
        
            'user_id' =>
                auth()->id()
        
        ]);
        JournalEntryLine::create([

            'journal_entry_id' =>
                $entry->id,
        
            'account_id' =>
                $inventoryAccount->id,
        
            'debit' =>
                $purchase->total,
        
            'credit' =>
                0
        
        ]);
        JournalEntryLine::create([

            'journal_entry_id' =>
                $entry->id,
        
            'account_id' =>
                $cashAccount->id,
        
            'debit' =>
                0,
        
            'credit' =>
                $purchase->total
        
        ]);

        $product = Product::find(
            $request->product_id
        );

        $product->increment(
            'quantity',
            $request->quantity
        );

        StockMovement::create([

            'product_id' => $product->id,
        
            'warehouse_id' => $request->warehouse_id,
        
            'user_id' => auth()->id(),
        
            'type' => 'in',
        
            'quantity' => $request->quantity,
        
        ]);
        $accounting = new AccountingService();

$inventory = Account::where('code','1100')->first();
$cash = Account::where('code','1000')->first();

$accounting->createEntry(
    'Purchase #' . $purchase->id,
    auth()->id(),
    [
        [
            'account_id' => $inventory->id,
            'debit' => $purchase->total,
        ],
        [
            'account_id' => $cash->id,
            'credit' => $purchase->total,
        ]
    ]
);
        return redirect()
            ->route('purchases.index')
            ->with(
                'success',
                'Purchase Created Successfully'
            );
    }
}