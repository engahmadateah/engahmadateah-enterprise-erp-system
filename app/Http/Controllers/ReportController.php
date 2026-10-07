<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        // revenue per month, last 12 months, cancelled sales excluded
        $since = now()->startOfMonth()->subMonths(11);

        $monthly = collect(range(0, 11))
            ->mapWithKeys(fn ($i) => [$since->copy()->addMonths($i)->format('Y-m') => 0.0]);

        Sale::active()
            ->where('created_at', '>=', $since)
            ->select('total', 'created_at')
            ->cursor()
            ->each(function ($sale) use (&$monthly) {
                $key = $sale->created_at->format('Y-m');
                if ($monthly->has($key)) {
                    $monthly[$key] += (float) $sale->total;
                }
            });

        $topProducts = Sale::active()
            ->selectRaw('product_id, SUM(quantity) as qty, SUM(total) as revenue')
            ->groupBy('product_id')
            ->orderByDesc('revenue')
            ->limit(5)
            ->with('product:id,name,sku')
            ->get();

        $lowStock = Product::where('is_active', true)
            ->whereColumn('quantity', '<=', 'low_stock')
            ->orderBy('quantity')
            ->limit(20)
            ->get();

        return view('reports.index', [
            'monthly'     => $monthly,
            'topProducts' => $topProducts,
            'lowStock'    => $lowStock,
            'cancelled'   => Sale::where('status', 'cancelled')->count(),
        ]);
    }

    public function exportSales(): StreamedResponse
    {
        return $this->csv('sales-' . now()->format('Ymd') . '.csv',
            ['Invoice', 'Date', 'Customer', 'Product', 'Warehouse', 'Qty', 'Unit price', 'Total', 'Status', 'Cashier'],
            function ($out) {
                Sale::with(['customer:id,name', 'product:id,name', 'warehouse:id,name', 'user:id,name'])
                    ->orderBy('id')
                    ->chunk(500, function ($sales) use ($out) {
                        foreach ($sales as $s) {
                            $this->row($out, [
                                $s->invoice_number, $s->created_at?->format('Y-m-d H:i'),
                                $s->customer?->name, $s->product?->name, $s->warehouse?->name,
                                $s->quantity, $s->unit_price, $s->total, $s->status, $s->user?->name,
                            ]);
                        }
                    });
            });
    }

    public function exportProducts(): StreamedResponse
    {
        return $this->csv('products-' . now()->format('Ymd') . '.csv',
            ['SKU', 'Name', 'Category', 'Quantity', 'Low stock at', 'Purchase price', 'Sale price', 'Active'],
            function ($out) {
                Product::with('category:id,name')->orderBy('id')->chunk(500, function ($products) use ($out) {
                    foreach ($products as $p) {
                        $this->row($out, [
                            $p->sku, $p->name, $p->category?->name, $p->quantity, $p->low_stock,
                            $p->purchase_price, $p->sale_price, $p->is_active ? 'yes' : 'no',
                        ]);
                    }
                });
            });
    }

    /* ---------------------------------------------------------------- */

    private function csv(string $filename, array $header, callable $body): StreamedResponse
    {
        return response()->streamDownload(function () use ($header, $body) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");          // UTF-8 BOM so Excel reads Arabic correctly
            $this->row($out, $header);
            $body($out);
            fclose($out);
        }, $filename, [
            'Content-Type'           => 'text/csv; charset=UTF-8',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * CSV-injection guard: a cell starting with = + - @ (or tab / CR) would be
     * executed as a formula by Excel / LibreOffice.
     */
    private function row($out, array $cells): void
    {
        fputcsv($out, array_map(function ($v) {
            $v = (string) ($v ?? '');

            return $v !== '' && str_contains("=+-@\t\r", $v[0]) && ! is_numeric($v)
                ? "'" . $v
                : $v;
        }, $cells));
    }
}
