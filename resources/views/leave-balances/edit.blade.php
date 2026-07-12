@extends('layouts.app')

@section('title','Edit Leave Balance')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Leave Balance
        </h1>

        <p class="text-orange-100 mt-2">
            Update employee leave allocation and balance information.
        </p>

    </div>



    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('leave-balances.update',$leaveBalance->id) }}"
            class="space-y-6">


            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Employee --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Employee
                    </label>


                    <input
                        type="text"
                        disabled
                        value="{{ $leaveBalance->employee->first_name }} {{ $leaveBalance->employee->last_name }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               bg-slate-100 text-slate-600 outline-none">


                </div>



                {{-- Annual Balance --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Annual Leave Balance
                    </label>


                    <input
                        type="number"
                        name="annual_balance"
                        value="{{ old('annual_balance',$leaveBalance->annual_balance) }}"
                        placeholder="Example: 30"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Used Balance --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Used Balance
                    </label>


                    <input
                        type="number"
                        value="{{ $leaveBalance->used_balance }}"
                        disabled
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               bg-slate-100 text-slate-600 outline-none">


                </div>



                {{-- Remaining Balance --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Remaining Balance
                    </label>


                    <input
                        type="number"
                        value="{{ $leaveBalance->remaining_balance }}"
                        disabled
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               bg-slate-100 text-slate-600 outline-none">


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Balance ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $leaveBalance->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('leave-balances.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 transition">

                        Cancel

                    </a>



                    <button
                        type="submit"
                        class="px-8 py-3 rounded-xl
                               bg-gradient-to-r from-orange-500 to-red-500
                               hover:from-orange-600 hover:to-red-600
                               text-white font-semibold shadow-lg transition">

                        Update Balance

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>


@endsection