@extends('layouts.app')

@section('title', 'Bonuses')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Bonuses
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Manage employee bonuses and reward outstanding performance with a modern dashboard.
                </p>

            </div>

            <a href="{{ route('bonuses.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">

                <span class="text-xl">💰</span>

                Add Bonus

            </a>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Bonuses
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">
                        {{ $bonuses->count() }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    🎁
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Amount
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ number_format($bonuses->sum('amount'),2) }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    💵
                </div>

            </div>

        </div>

    </div>
    {{-- Bonuses Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Bonus Records
            </h2>

            <p class="text-slate-500 mt-1">
                List of all employee bonus records.
            </p>

        </div>

        <div class="overflow-x-auto" dir="ltr">

            <table class="min-w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">
                            Employee
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Reason
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Date
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bonuses as $bonus)

                    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">

                                    {{ strtoupper(substr($bonus->employee->first_name,0,1)) }}

                                </div>

                                <div>

                                    <div class="font-bold text-slate-800">

                                        {{ $bonus->employee->first_name }}
                                        {{ $bonus->employee->last_name }}

                                    </div>

                                    <div class="text-sm text-slate-500">

                                        Bonus Record

                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5">
                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-bold">

💰 {{ number_format($bonus->amount,2) }}

</span>

</td>

<td class="px-6 py-5 text-slate-700">

{{ $bonus->reason }}

</td>

<td class="px-6 py-5 text-slate-700 font-medium">

{{ $bonus->date }}

</td>

</tr>

@empty

<tr>

<td colspan="4" class="px-6 py-16 text-center">

<div class="flex flex-col items-center">

<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">
    🎁
</div>

<h3 class="text-xl font-bold text-slate-700">
    No Bonus Records Found
</h3>

<p class="text-slate-500 mt-2">
    There are currently no bonus records available.
</p>

</div>

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection