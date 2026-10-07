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
use Illuminate\Support\Facades\DB;
use RuntimeException;

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

    public function store(Request $request, AccountingService $accounting)
    {
        $data = $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'product_id'   => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity'     => 'required|integer|min:1|max:1000000',
        ]);

        try {
            DB::transaction(function () use ($data, $accounting) {

                $acc = $accounting->accounts(['1000', '4000']);

                // lock the row so two concurrent sales cannot oversell
                $product = Product::lockForUpdate()->findOrFail($data['product_id']);

                if ($data['quantity'] > $product->quantity) {
                    throw new RuntimeException('Not enough stock');
                }

                $total = round($product->sale_price * $data['quantity'], 2);

                $sale = Sale::create([
                    'customer_id'  => $data['customer_id'],
                    'product_id'   => $product->id,
                    'warehouse_id' => $data['warehouse_id'],
                    'quantity'     => $data['quantity'],
                    'unit_price'   => $product->sale_price,
                    'total'        => $total,
                    'user_id'      => auth()->id(),
                ]);

                // id based => unique, no more rand() collisions
                $sale->update([
                    'invoice_number' => 'INV-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT),
                ]);

                $product->decrement('quantity', $data['quantity']);

                StockMovement::create([
                    'product_id'   => $product->id,
                    'warehouse_id' => $data['warehouse_id'],
                    'user_id'      => auth()->id(),
                    'type'         => 'out',
                    'quantity'     => $data['quantity'],
                    'note'         => 'Sale #' . $sale->id,
                ]);

                $accounting->createEntry(
                    'Sale Invoice ' . $sale->invoice_number,
                    auth()->id(),
                    [
                        ['account_id' => $acc['1000']->id, 'debit'  => $total],
                        ['account_id' => $acc['4000']->id, 'credit' => $total],
                    ]
                );
            });
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale Created');
    }

    /**
     * Cancel a sale: stock goes back, a reversing journal entry is posted.
     * Nothing is deleted, so the audit trail and invoice numbering stay intact.
     */
    public function cancel(Request $request, Sale $sale, AccountingService $accounting)
    {
        $data = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($sale, $data, $accounting) {

                $acc = $accounting->accounts(['1000', '4000']);

                // lock so a double click cannot restore the stock twice
                $locked = Sale::lockForUpdate()->findOrFail($sale->id);

                if ($locked->isCancelled()) {
                    throw new RuntimeException('This sale is already cancelled.');
                }

                Product::whereKey($locked->product_id)->increment('quantity', $locked->quantity);

                StockMovement::create([
                    'product_id'   => $locked->product_id,
                    'warehouse_id' => $locked->warehouse_id,
                    'user_id'      => auth()->id(),
                    'type'         => 'in',
                    'quantity'     => $locked->quantity,
                    'note'         => 'Cancel ' . $locked->invoice_number,
                ]);

                $accounting->createEntry(
                    'Reversal of ' . $locked->invoice_number . ' (cancelled)',
                    auth()->id(),
                    [
                        ['account_id' => $acc['4000']->id, 'debit'  => $locked->total],
                        ['account_id' => $acc['1000']->id, 'credit' => $locked->total],
                    ]
                );

                $locked->update([
                    'status'        => 'cancelled',
                    'cancelled_at'  => now(),
                    'cancelled_by'  => auth()->id(),
                    'cancel_reason' => $data['reason'],
                ]);

                \App\Models\AuditLog::record('sale.cancelled', $locked, $data['reason']);
            });
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Sale cancelled and stock restored');
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
