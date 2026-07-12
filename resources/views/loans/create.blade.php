@extends('layouts.app')

@section('title','Add Loan')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Loan
        </h1>

        <p class="text-indigo-100 mt-2">
            Create an employee loan and manage repayment details.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('loans.store') }}"
            class="space-y-6">

            @csrf



            {{-- Employee --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Employee
                </label>


                <select
                    name="employee_id"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


                    <option value="">
                        Select employee
                    </option>


                    @foreach($employees as $employee)

                        <option value="{{ $employee->id }}">

                            {{ $employee->employee_no }}
                            -
                            {{ $employee->first_name }}
                            {{ $employee->last_name }}

                        </option>

                    @endforeach


                </select>

            </div>



            {{-- Loan Amount --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Loan Amount
                </label>


                <input
                    type="number"
                    step="0.01"
                    name="amount"
                    value="{{ old('amount') }}"
                    placeholder="Example: 5000.00"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Monthly Installment --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Monthly Installment
                </label>


                <input
                    type="number"
                    step="0.01"
                    name="monthly_installment"
                    value="{{ old('monthly_installment') }}"
                    placeholder="Example: 500.00"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>
            {{-- Start Date --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Start Date
                </label>


                <input
                    type="date"
                    name="start_date"
                    value="{{ old('start_date') }}"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Notes --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Notes
                </label>


                <textarea
                    name="notes"
                    rows="5"
                    placeholder="Example: Employee emergency loan request."
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">{{ old('notes') }}</textarea>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('loans.index') }}"
                   class="px-6 py-3 rounded-xl
                          border border-slate-300
                          text-slate-700
                          hover:bg-slate-100
                          transition">

                    Cancel

                </a>


                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r from-indigo-600 to-violet-600
                           hover:from-indigo-700 hover:to-violet-700
                           text-white font-semibold
                           shadow-lg
                           transition">

                    Save Loan

                </button>


            </div>


        </form>


    </div>


</div>


@endsection