@extends('layouts.app')

@section('title', 'Loans')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Employee Loans
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Manage employee loans, installments, and repayment status from one modern dashboard.
                </p>

            </div>

            <a href="{{ route('loans.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">

                <span class="text-xl">💳</span>

                Add Loan

            </a>

        </div>

    </div>


    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Loans
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">
                        {{ $loans->count() }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    📋
                </div>

            </div>

        </div>



        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Active Loans
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $loans->where('is_closed',false)->count() }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    🔴
                </div>

            </div>

        </div>



        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Closed Loans
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $loans->where('is_closed',true)->count() }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    ✅
                </div>

            </div>

        </div>


    </div>
    {{-- Loans Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">


        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Loan Records
            </h2>

            <p class="text-slate-500 mt-1">
                List of all employee loan details and repayment progress.
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
                            Loan Amount
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Installment
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Remaining
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Status
                        </th>

                    </tr>

                </thead>



                <tbody>


                    @forelse($loans as $loan)


                    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">


                        <td class="px-6 py-5">


                            <div class="flex items-center gap-4">


                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">


                                    {{ strtoupper(substr($loan->employee->first_name,0,1)) }}


                                </div>


                                <div>


                                    <div class="font-bold text-slate-800">

                                        {{ $loan->employee->first_name }}
                                        {{ $loan->employee->last_name }}

                                    </div>


                                    <div class="text-sm text-slate-500">

                                        Loan Record

                                    </div>


                                </div>


                            </div>


                        </td>



                        <td class="px-6 py-5">

                            <span class="inline-flex items-center px-4 py-2 rounded-xl bg-orange-100 text-orange-700 font-bold">

                                💳 {{ number_format($loan->amount,2) }}

                            </span>

                        </td>



                        <td class="px-6 py-5 text-slate-700 font-semibold">

                            {{ number_format($loan->monthly_installment,2) }}

                        </td>


                        <td class="px-6 py-5 text-slate-700 font-semibold">

                            {{ number_format($loan->remaining_balance,2) }}

                        </td>


                        <td class="px-6 py-5">
                        @if($loan->is_closed)

<span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-semibold">

    ✅ Closed

</span>

@else

<span class="inline-flex items-center px-4 py-2 rounded-xl bg-red-100 text-red-700 font-semibold">

    🔴 Active

</span>

@endif


</td>


</tr>


@empty


<tr>


<td colspan="5" class="px-6 py-16 text-center">


<div class="flex flex-col items-center">


<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">

    💳

</div>


<h3 class="text-xl font-bold text-slate-700">

    No Loan Records Found

</h3>


<p class="text-slate-500 mt-2">

    There are currently no employee loans available.

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