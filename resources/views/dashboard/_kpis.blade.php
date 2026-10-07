@if(! empty($kpis))
<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

    @isset($kpis['sales_today'])
        <div class="bg-white rounded-3xl shadow p-6">
            <div class="text-slate-500 text-sm">Sales today</div>
            <div class="text-3xl font-black text-slate-800 mt-2">{{ number_format($kpis['sales_today'], 2) }}</div>
        </div>
        <div class="bg-white rounded-3xl shadow p-6">
            <div class="text-slate-500 text-sm">Sales this month</div>
            <div class="text-3xl font-black text-slate-800 mt-2">{{ number_format($kpis['sales_month'], 2) }}</div>
        </div>
    @endisset

    @isset($kpis['low_stock'])
        <a href="{{ route('reports.index') }}" class="bg-white rounded-3xl shadow p-6 block">
            <div class="text-slate-500 text-sm">Low-stock products</div>
            <div class="text-3xl font-black mt-2 {{ $kpis['low_stock'] > 0 ? 'text-amber-600' : 'text-green-600' }}">{{ $kpis['low_stock'] }}</div>
        </a>
    @endisset

    @isset($kpis['pending_leaves'])
        <a href="{{ route('leaves.index') }}" class="bg-white rounded-3xl shadow p-6 block">
            <div class="text-slate-500 text-sm">Pending leave requests</div>
            <div class="text-3xl font-black text-slate-800 mt-2">{{ $kpis['pending_leaves'] }}</div>
        </a>
    @endisset

    @isset($kpis['open_tickets'])
        <a href="{{ route('tickets.manage') }}" class="bg-white rounded-3xl shadow p-6 block">
            <div class="text-slate-500 text-sm">Open IT tickets</div>
            <div class="text-3xl font-black text-slate-800 mt-2">{{ $kpis['open_tickets'] }}</div>
        </a>
    @endisset

</div>
@endif
