@extends('layouts.app')

@section('title','Request Leave')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Leave Request
        </h1>

        <p class="text-indigo-100 mt-2">
            Submit a new leave request and manage your time off.
        </p>

    </div>


    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        @if ($errors->any())

            <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-xl mb-6">

                <ul class="space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        <form
            method="POST"
            action="{{ route('my-leaves.store') }}"
            class="space-y-6">

            @csrf



            {{-- Leave Type --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Leave Type
                </label>


                <select
                    name="leave_type_id"
                    required
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


                    <option value="">
                        Select leave type
                    </option>


                    @foreach($leaveTypes as $type)

                        <option value="{{ $type->id }}"
                            {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>

                            {{ $type->name }}

                        </option>

                    @endforeach


                </select>


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
                    placeholder="Example: 2026-07-15"
                    required
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>
            {{-- End Date --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    End Date
                </label>


                <input
                    type="date"
                    name="end_date"
                    value="{{ old('end_date') }}"
                    placeholder="Example: 2026-07-20"
                    required
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Reason --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Reason
                </label>


                <textarea
                    name="reason"
                    rows="5"
                    placeholder="Example: I need leave for a family event."
                    required
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">{{ old('reason') }}</textarea>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('my-leaves.index') }}"
                   class="px-6 py-3 rounded-xl
                          border border-slate-300
                          text-slate-700
                          hover:bg-slate-100
                          transition">

                    My Leave Requests

                </a>


                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r from-indigo-600 to-violet-600
                           hover:from-indigo-700 hover:to-violet-700
                           text-white font-semibold
                           shadow-lg
                           transition">

                    Submit Leave Request

                </button>


            </div>


        </form>


    </div>


</div>


@endsection