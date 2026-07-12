<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Account;
use App\Services\AccountingService;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with([
            'product',
            'warehouse',
            'customer',
            'user'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'sales.index',
            compact('sales')
        );
    }

    public function create()
    {
        $products = Product::all();

        $warehouses = Warehouse::all();

        $customers = Customer::all();

        return view(
            'sales.create',
            compact(
                'products',
                'warehouses',
                'customers'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'customer_id' => 'required',

            'product_id' => 'required',

            'warehouse_id' => 'required',

            'quantity' => 'required|integer|min:1',

        ]);

        $product = Product::findOrFail(
            $request->product_id
        );

        if (
            $request->quantity >
            $product->quantity
        ) {
            return back()
                ->with(
                    'error',
                    'Not enough stock'
                );
        }

        $total =
            $product->sale_price *
            $request->quantity;

        $sale = Sale::create([

            'invoice_number' =>
                'INV-' .
                now()->format('YmdHis') .
                '-' .
                rand(100,999),

            'customer_id' =>
                $request->customer_id,

            'product_id' =>
                $product->id,

            'warehouse_id' =>
                $request->warehouse_id,

            'quantity' =>
                $request->quantity,

            'unit_price' =>
                $product->sale_price,

            'total' =>
                $total,

            'user_id' =>
                auth()->id(),

        ]);

        $product->decrement(
            'quantity',
            $request->quantity
        );

        StockMovement::create([

            'product_id' =>
                $product->id,

            'warehouse_id' =>
                $request->warehouse_id,

            'user_id' =>
                auth()->id(),

            'type' =>
                'out',

            'quantity' =>
                $request->quantity,

            'note' =>
                'Sale #'.$sale->id,

        ]);

        $cash = Account::where(
            'code',
            '1000'
        )->first();

        $salesAccount = Account::where(
            'code',
            '4000'
        )->first();

        if ($cash && $salesAccount) {

            $accounting = new AccountingService();

            $accounting->createEntry(
                'Sale Invoice '.$sale->invoice_number,
                auth()->id(),
                [
                    [
                        'account_id' =>
                            $cash->id,

                        'debit' =>
                            $sale->total,
                    ],
                    [
                        'account_id' =>
                            $salesAccount->id,

                        'credit' =>
                            $sale->total,
                    ]
                ]
            );
        }

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale Created'
            );
    }

    public function invoice(Sale $sale)
    {
        $sale->load([
            'product',
            'customer',
            'warehouse',
            'user'
        ]);

        return view(
            'sales.invoice',
            compact('sale')
        );
    }

    public function pdf(Sale $sale)
    {
        $sale->load([
            'customer',
            'product',
            'warehouse',
            'user'
        ]);

        $pdf = Pdf::loadView(
            'sales.invoice-pdf',
            compact('sale')
        );

        return $pdf->download(
            'Invoice-'.$sale->invoice_number.'.pdf'
        );
    }
}
