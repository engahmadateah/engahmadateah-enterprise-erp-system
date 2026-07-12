@extends('layouts.app')

@section('title', 'Payroll')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col xl:flex-row justify-between items-center gap-8">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Payroll Management
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Generate monthly payroll and review employee salary details in one modern dashboard.
                </p>

            </div>

            <form method="POST"
                  action="{{ route('payroll.generate') }}"
                  class="bg-white rounded-3xl shadow-xl p-5 flex flex-col sm:flex-row items-center gap-4">

                @csrf

                <input
                    type="number"
                    name="month"
                    placeholder="Month"
                    class="w-32 px-4 py-3 rounded-xl border border-slate-200
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                <input
                    type="number"
                    name="year"
                    placeholder="Year"
                    class="w-36 px-4 py-3 rounded-xl border border-slate-200
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                <button
                    type="submit"
                    class="inline-flex items-center gap-3 px-7 py-3 rounded-2xl
                           bg-gradient-to-r from-green-500 to-emerald-600
                           hover:from-green-600 hover:to-emerald-700
                           text-white font-semibold shadow-lg transition">

                    💰 Generate Payroll

                </button>

            </form>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Payrolls
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-slate-800">
                        {{ $payrolls->count() }}
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
                        Total Bonuses
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ number_format($payrolls->sum('bonus_amount'),2) }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    💵
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Deductions
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ number_format($payrolls->sum('advance_deduction') + $payrolls->sum('loan_deduction'),2) }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    📉
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Net Salary
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">
                        {{ number_format($payrolls->sum('net_salary'),2) }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    💰
                </div>

            </div>

        </div>

    </div>
    {{-- Payroll Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Payroll Records
            </h2>

            <p class="text-slate-500 mt-1">
                List of all generated employee payroll records.
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
                            Period
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Basic
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Attendance
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Bonus
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Overtime
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Advance
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Loan
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Net Salary
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payrolls as $payroll)

                    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">

                                    {{ strtoupper(substr($payroll->employee->first_name,0,1)) }}

                                </div>

                                <div>

                                    <div class="font-bold text-slate-800">
                                    <a href="{{ route('payroll.slip',$payroll->id) }}"
   class="font-bold text-slate-800 hover:text-indigo-600 transition">

    {{ $payroll->employee->first_name }}
    {{ $payroll->employee->last_name }}

</a>

                                    </div>

                                    <div class="text-sm text-slate-500">

                                        Payroll Record

                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 font-medium text-slate-700">

                            {{ $payroll->month }}/{{ $payroll->year }}

                        </td>

                        <td class="px-6 py-5 text-slate-700">

                            {{ number_format($payroll->basic_salary,2) }}

                        </td>

                        <td class="px-6 py-5 text-blue-600 font-semibold">

                            {{ number_format($payroll->attendance_salary,2) }}

                        </td>

                        <td class="px-6 py-5 text-green-600 font-semibold">

                            {{ number_format($payroll->bonus_amount,2) }}

                        </td>

                        <td class="px-6 py-5 text-green-600 font-semibold">

                            {{ number_format($payroll->overtime_amount,2) }}

                        </td>

                        <td class="px-6 py-5 text-red-600 font-semibold">

                            {{ number_format($payroll->advance_deduction,2) }}

                        </td>

                        <td class="px-6 py-5 text-red-600 font-semibold">

                            {{ number_format($payroll->loan_deduction,2) }}

                        </td>

                        <td class="px-6 py-5">
                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-100 text-indigo-700 font-bold">

💰 {{ number_format($payroll->net_salary,2) }}

</span>

</td>

</tr>

@empty

<tr>

<td colspan="9" class="px-6 py-16 text-center">

<div class="flex flex-col items-center">

<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">
    💰
</div>

<h3 class="text-xl font-bold text-slate-700">
    No Payroll Records Found
</h3>

<p class="text-slate-500 mt-2">
    There are currently no payroll records available.
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