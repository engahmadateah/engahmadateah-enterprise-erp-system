@extends('layouts.app')

@section('title', 'Daily Attendance')

@section('content')

@php
    $presentCount = collect($attendances)->where('status', 'present')->count();
    $lateCount = collect($attendances)->where('status', 'late')->count();
    $absentCount = collect($attendances)->where('status', 'absent')->count();
    $leaveCount = collect($attendances)->where('status', 'leave')->count();
@endphp

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Daily Attendance
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Manage employee attendance, check-in, check-out and daily status from one modern dashboard.
                </p>

            </div>

            <div class="bg-white/20 backdrop-blur rounded-2xl px-6 py-4">

                <div class="text-indigo-100 text-sm">
                    Attendance Date
                </div>

                <div class="text-white text-2xl font-bold">
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </div>

            </div>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Employees
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-slate-800">
                        {{ $employees->count() }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    👥
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Present
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $presentCount }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    ✅
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Late
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-amber-600">
                        {{ $lateCount }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center text-3xl">
                    ⏰
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Absent / Leave
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $absentCount + $leaveCount }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    ❌
                </div>

            </div>

        </div>

    </div>

    {{-- Date Card --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

        <form method="GET">

            <div class="flex flex-col lg:flex-row gap-4 items-end">

                <div class="flex-1">

                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Attendance Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="{{ $date }}"
                        class="w-full rounded-2xl border border-slate-200 px-5 py-4 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none">

                </div>

                <button
                    class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold shadow-lg transition">

                    Load Attendance

                </button>

            </div>

        </form>

    </div>

    <form method="POST"
          action="{{ route('attendance.daily-sheet.save') }}">

        @csrf

        <input
            type="hidden"
            name="attendance_date"
            value="{{ $date }}">

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

            <div class="px-6 py-5 border-b bg-slate-50">

                <h2 class="text-2xl font-bold text-slate-800">
                    Employee Attendance Sheet
                </h2>

                <p class="text-slate-500 mt-1">
                    Fill attendance for all employees.
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
                                Department
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Check In
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Check Out
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Notes
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                    @foreach($employees as $employee)

@php
    $attendance = $attendances[$employee->id] ?? null;
@endphp

<tr class="border-b border-slate-100 hover:bg-indigo-50 transition">

    <td class="px-6 py-5">

        <div class="flex items-center gap-4">

            @if($employee->avatar)

                <img
                    src="{{ asset('storage/'.$employee->avatar) }}"
                    class="w-14 h-14 rounded-2xl object-cover ring-4 ring-indigo-50">

            @else

                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">

                    {{ strtoupper(substr($employee->first_name,0,1)) }}

                </div>

            @endif

            <div>

                <div class="font-bold text-slate-800">

                    {{ $employee->first_name }}
                    {{ $employee->last_name }}

                </div>

                <div class="text-sm text-slate-500">

                    {{ $employee->employee_no }}

                </div>

            </div>

        </div>

    </td>

    <td class="px-6 py-5">

        <span class="inline-flex px-4 py-2 rounded-xl bg-slate-100 font-medium">

            {{ $employee->department->name ?? '-' }}

        </span>

    </td>

    <td class="px-6 py-5">

        <input
            type="time"
            name="employees[{{ $employee->id }}][check_in]"
            value="{{ $attendance?->check_in }}"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none">

    </td>

    <td class="px-6 py-5">

        <input
            type="time"
            name="employees[{{ $employee->id }}][check_out]"
            value="{{ $attendance?->check_out }}"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none">

    </td>

    <td class="px-6 py-5">

        <select
            name="employees[{{ $employee->id }}][status]"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none">

            <option value="present"
                {{ $attendance?->status=='present' ? 'selected' : '' }}>
                ✅ Present
            </option>

            <option value="late"
                {{ $attendance?->status=='late' ? 'selected' : '' }}>
                ⏰ Late
            </option>

            <option value="absent"
                {{ $attendance?->status=='absent' ? 'selected' : '' }}>
                ❌ Absent
            </option>

            <option value="leave"
                {{ $attendance?->status=='leave' ? 'selected' : '' }}>
                🌴 Leave
            </option>

        </select>

    </td>

    <td class="px-6 py-5">

        <input
            type="text"
            name="employees[{{ $employee->id }}][notes]"
            value="{{ $attendance?->notes }}"
            placeholder="Notes..."
            class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none">

    </td>

</tr>

@endforeach
</tbody>

</table>

</div>

</div>

<div class="mt-8 flex justify-end">

<button
type="submit"
class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl
       bg-gradient-to-r from-green-600 to-emerald-600
       hover:from-green-700 hover:to-emerald-700
       text-white font-semibold shadow-xl transition">

<span class="text-xl">💾</span>

Save Attendance

</button>

</div>

</form>

</div>

@endsection