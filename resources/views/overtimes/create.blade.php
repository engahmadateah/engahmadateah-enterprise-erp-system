@extends('layouts.app')

@section('title','Add Overtime')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Overtime
        </h1>

        <p class="text-indigo-100 mt-2">
            Record employee overtime and calculate overtime payment automatically.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('overtimes.store') }}"
            class="space-y-6">

            @csrf



            {{-- Employee --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Employee
                </label>


                <select
                    id="employee"
                    name="employee_id"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


                    <option value="">
                        Select employee
                    </option>


                    @foreach($employees as $employee)

                        <option
                            value="{{ $employee->id }}"
                            data-salary="{{ $employee->salary }}">

                            {{ $employee->employee_no }}
                            -
                            {{ $employee->first_name }}
                            {{ $employee->last_name }}

                        </option>

                    @endforeach


                </select>


            </div>



            {{-- Date --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Overtime Date
                </label>


                <input
                    type="date"
                    name="date"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Overtime Hours --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Overtime Hours
                </label>


                <input
                    type="number"
                    step="0.5"
                    id="hours"
                    name="hours"
                    placeholder="Example: 3.5"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>
            {{-- Calculation --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                {{-- Daily Rate --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Daily Rate
                    </label>

                    <input
                        id="daily_rate"
                        readonly
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               bg-slate-100 text-slate-700">

                </div>



                {{-- Hour Rate --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Hour Rate
                    </label>

                    <input
                        id="hour_rate"
                        readonly
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               bg-slate-100 text-slate-700">

                </div>



                {{-- Total Amount --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Total Amount
                    </label>

                    <input
                        id="total_amount"
                        readonly
                        class="w-full rounded-xl border border-emerald-300 px-5 py-3
                               bg-emerald-50 text-emerald-700 font-semibold">

                </div>


            </div>



            {{-- Notes --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Notes
                </label>


                <textarea
                    name="notes"
                    rows="5"
                    placeholder="Example: Worked extra hours for project completion."
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none"></textarea>

            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('overtimes.index') }}"
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

                    Save Overtime

                </button>


            </div>


        </form>

    </div>

</div>



@push('scripts')

<script>

const employee =
    document.getElementById('employee');

const hours =
    document.getElementById('hours');


function calculate()
{
    let salary =
        employee.options[
            employee.selectedIndex
        ]?.dataset.salary || 0;


    let dailyRate =
        salary / 30;


    let hourRate =
        dailyRate / 8;


    let total =
        hourRate * (hours.value || 0);



    document.getElementById(
        'daily_rate'
    ).value =
        dailyRate.toFixed(2);



    document.getElementById(
        'hour_rate'
    ).value =
        hourRate.toFixed(2);



    document.getElementById(
        'total_amount'
    ).value =
        total.toFixed(2);

}



employee.addEventListener(
    'change',
    calculate
);



hours.addEventListener(
    'input',
    calculate
);


</script>

@endpush


@endsection