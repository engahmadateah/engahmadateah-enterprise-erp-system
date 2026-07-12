@extends('layouts.app')

@section('title','Add Bonus')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Bonus
        </h1>

        <p class="text-indigo-100 mt-2">
            Add a bonus reward for an employee.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('bonuses.store') }}"
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

                        <option value="{{ $employee->id }}"
                            {{ old('employee_id') == $employee->id ? 'selected' : '' }}>

                            {{ $employee->employee_no }}
                            -
                            {{ $employee->first_name }}
                            {{ $employee->last_name }}

                        </option>

                    @endforeach


                </select>

            </div>



            {{-- Bonus Amount --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Bonus Amount
                </label>


                <input
                    type="number"
                    step="0.01"
                    name="amount"
                    value="{{ old('amount') }}"
                    placeholder="Example: 500.00"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>
            {{-- Reason --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Reason
                </label>


                <input
                    type="text"
                    name="reason"
                    value="{{ old('reason') }}"
                    placeholder="Example: Performance reward"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Date --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Bonus Date
                </label>


                <input
                    type="date"
                    name="date"
                    value="{{ old('date') }}"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('bonuses.index') }}"
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

                    Save Bonus

                </button>


            </div>


        </form>


    </div>


</div>


@endsection