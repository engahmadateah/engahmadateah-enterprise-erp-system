@extends('layouts.app')

@section('title','Reports')

@section('content')

@php $max = max(1, $monthly->max()); @endphp

<div class="space-y-8">

    <div class="rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl
                flex flex-col lg:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-4xl font-bold text-white">Reports</h1>
            <p class="text-indigo-100 mt-3">Sales trend, best sellers and stock alerts. Cancelled sales are excluded.</p>
        </div>

        <div class="flex gap-3">
            @can('sales.view')
                <a href="{{ route('reports.export.sales') }}" class="px-5 py-3 rounded-2xl bg-white text-indigo-700 font-semibold shadow">⬇ Sales CSV</a>
            @endcan
            @can('products.view')
                <a href="{{ route('reports.export.products') }}" class="px-5 py-3 rounded-2xl bg-white text-indigo-700 font-semibold shadow">⬇ Products CSV</a>
            @endcan
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Revenue — last 12 months</h2>

        <div class="flex items-end gap-2 h-56">
            @foreach($monthly as $month => $total)
                <div class="flex-1 flex flex-col items-center justify-end h-full" title="{{ $month }}: {{ number_format($total, 2) }}">
                    <div class="text-[10px] text-slate-500 mb-1">{{ $total > 0 ? number_format($total, 0) : '' }}</div>
                    <div class="w-full rounded-t-lg bg-indigo-500" style="height: {{ max(2, round($total / $max * 100)) }}%"></div>
                    <div class="text-[10px] text-slate-500 mt-2">{{ substr($month, 5) }}/{{ substr($month, 2, 2) }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Top products</h2>
            <table class="w-full text-sm">
                <thead class="text-slate-500 text-xs uppercase">
                    <tr><th class="text-left py-2">Product</th><th class="text-right">Qty</th><th class="text-right">Revenue</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($topProducts as $row)
                        <tr>
                            <td class="py-3">{{ $row->product?->name ?? '—' }}</td>
                            <td class="text-right">{{ $row->qty }}</td>
                            <td class="text-right font-semibold">{{ number_format($row->revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-6 text-center text-slate-400">No sales yet</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($cancelled)
                <p class="text-xs text-slate-400 mt-4">{{ $cancelled }} cancelled sale(s) not counted.</p>
            @endif
        </div>

        <div class="bg-white rounded-3xl shadow p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Low stock</h2>
            <table class="w-full text-sm">
                <thead class="text-slate-500 text-xs uppercase">
                    <tr><th class="text-left py-2">Product</th><th class="text-right">In stock</th><th class="text-right">Alert at</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($lowStock as $p)
                        <tr>
                            <td class="py-3">{{ $p->name }} <span class="text-slate-400">({{ $p->sku }})</span></td>
                            <td class="text-right font-bold {{ $p->quantity == 0 ? 'text-red-600' : 'text-amber-600' }}">{{ $p->quantity }}</td>
                            <td class="text-right">{{ $p->low_stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-6 text-center text-slate-400">Everything is stocked 👍</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
