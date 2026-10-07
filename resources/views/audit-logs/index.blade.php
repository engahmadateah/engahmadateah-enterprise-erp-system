@extends('layouts.app')

@section('title','Audit Log')

@section('content')

<div class="space-y-8">

    <div class="rounded-3xl bg-gradient-to-r from-slate-800 to-slate-900 p-8 shadow-2xl">
        <h1 class="text-4xl font-bold text-white">Audit Log</h1>
        <p class="text-slate-300 mt-3">Who did what, when and from where. Passwords are never stored here.</p>
    </div>

    <form method="GET" class="bg-white rounded-3xl shadow p-6 grid grid-cols-1 md:grid-cols-6 gap-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search description / model / IP"
               class="md:col-span-2 rounded-xl border border-slate-300 px-4 py-2">

        <select name="event" class="rounded-xl border border-slate-300 px-4 py-2">
            <option value="">All events</option>
            @foreach($events as $event)
                <option value="{{ $event }}" @selected(request('event') === $event)>{{ $event }}</option>
            @endforeach
        </select>

        <select name="user" class="rounded-xl border border-slate-300 px-4 py-2">
            <option value="">All users</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" @selected((string) request('user') === (string) $u->id)>{{ $u->name }}</option>
            @endforeach
        </select>

        <input type="date" name="from" value="{{ request('from') }}" class="rounded-xl border border-slate-300 px-4 py-2">
        <input type="date" name="to" value="{{ request('to') }}" class="rounded-xl border border-slate-300 px-4 py-2">

        <button class="md:col-span-6 md:w-40 bg-indigo-600 text-white rounded-xl px-6 py-2 font-semibold">Filter</button>
    </form>

    <div class="bg-white rounded-3xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="px-5 py-4 text-left">When</th>
                    <th class="px-5 py-4 text-left">User</th>
                    <th class="px-5 py-4 text-left">Event</th>
                    <th class="px-5 py-4 text-left">Subject</th>
                    <th class="px-5 py-4 text-left">Details</th>
                    <th class="px-5 py-4 text-left">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($logs as $log)
                    <tr class="align-top">
                        <td class="px-5 py-3 whitespace-nowrap">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                        <td class="px-5 py-3">{{ $log->user?->name ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-semibold">{{ $log->event }}</span>
                        </td>
                        <td class="px-5 py-3">
                            {{ $log->auditable_type }}@if($log->auditable_id) #{{ $log->auditable_id }}@endif
                        </td>
                        <td class="px-5 py-3 max-w-md">
                            @if($log->description)<div class="font-medium">{{ $log->description }}</div>@endif
                            @if($log->old_values || $log->new_values)
                                <details class="mt-1 text-xs text-slate-600">
                                    <summary class="cursor-pointer text-indigo-600">changes</summary>
                                    @if($log->old_values)<pre class="whitespace-pre-wrap break-all">old: {{ json_encode($log->old_values, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>@endif
                                    @if($log->new_values)<pre class="whitespace-pre-wrap break-all">new: {{ json_encode($log->new_values, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>@endif
                                </details>
                            @endif
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No entries</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $logs->links() }}

</div>

@endsection
