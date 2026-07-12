@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Attendance
        </h1>

        <p class="text-orange-100 mt-2">
            Update employee attendance information and status.
        </p>

    </div>



    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('attendance.update',$attendance->id) }}"
            class="space-y-6">

            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Employee --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Employee
                    </label>


                    <select
                        name="employee_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>

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

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Attendance Date
                    </label>


                    <input
                        type="date"
                        name="attendance_date"
                        value="{{ $attendance->attendance_date }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Check In --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Check In
                    </label>


                    <input
                        type="time"
                        name="check_in"
                        value="{{ $attendance->check_in }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Check Out --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Check Out
                    </label>


                    <input
                        type="time"
                        name="check_out"
                        value="{{ $attendance->check_out }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Status --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Status
                    </label>


                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                        <option value="present"
                            {{ $attendance->status == 'present' ? 'selected' : '' }}>
                            Present
                        </option>


                        <option value="late"
                            {{ $attendance->status == 'late' ? 'selected' : '' }}>
                            Late
                        </option>


                        <option value="absent"
                            {{ $attendance->status == 'absent' ? 'selected' : '' }}>
                            Absent
                        </option>


                        <option value="leave"
                            {{ $attendance->status == 'leave' ? 'selected' : '' }}>
                            Leave
                        </option>


                    </select>


                </div>


            </div>



            {{-- Notes --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Notes
                </label>


                <textarea
                    name="notes"
                    rows="4"
                    placeholder="Example: Employee arrived late due to traffic."
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">{{ $attendance->notes }}</textarea>


            </div>



            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Attendance ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $attendance->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('attendance.index') }}"
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

                        Update Attendance

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>


@endsection