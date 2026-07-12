@extends('layouts.app')

@section('title', 'Attendance')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Attendance Records
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    View and manage employee attendance records with a modern dashboard.
                </p>

            </div>

            @can('attendance.create')

            <a href="{{ route('attendance.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">

                <span class="text-xl">➕</span>

                Add Attendance

            </a>

            @endcan

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Records
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-slate-800">
                        {{ $attendances->count() }}
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
                        Present
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $attendances->where('status','present')->count() }}
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
                        {{ $attendances->where('status','late')->count() }}
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
                        {{ $attendances->whereIn('status',['absent','leave'])->count() }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    ❌
                </div>

            </div>

        </div>

    </div>

    {{-- Attendance Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Attendance Records
            </h2>

            <p class="text-slate-500 mt-1">
                List of all employee attendance records.
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
            Date
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

        <th class="px-6 py-4 text-center font-semibold">
            Actions
        </th>

    </tr>

</thead>

<tbody>

    @foreach($attendances as $attendance)

    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">

        <td class="px-6 py-5">

            <div class="flex items-center gap-4">

                @if($attendance->employee->avatar)

                    <img
                        src="{{ asset('storage/'.$attendance->employee->avatar) }}"
                        class="w-14 h-14 rounded-2xl object-cover ring-4 ring-indigo-50">

                @else

                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">

                        {{ strtoupper(substr($attendance->employee->first_name,0,1)) }}

                    </div>

                @endif

                <div>

                    <div class="font-bold text-slate-800">

                        {{ $attendance->employee->first_name }}
                        {{ $attendance->employee->last_name }}

                    </div>

                    <div class="text-sm text-slate-500">

                        {{ $attendance->employee->employee_no }}

                    </div>

                </div>

            </div>

        </td>

        <td class="px-6 py-5 font-medium text-slate-700">
            {{ $attendance->attendance_date }}
        </td>

        <td class="px-6 py-5 text-slate-700">
            {{ $attendance->check_in ?? '-' }}
        </td>

        <td class="px-6 py-5 text-slate-700">
            {{ $attendance->check_out ?? '-' }}
        </td>

        <td class="px-6 py-5">

            @if($attendance->status == 'present')

                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-semibold">
                    ✅ Present
                </span>

            @elseif($attendance->status == 'late')

                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-semibold">
                    ⏰ Late
                </span>

            @elseif($attendance->status == 'absent')

                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-red-100 text-red-700 font-semibold">
                    ❌ Absent
                </span>

            @else

                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold">
                    🌴 Leave
                </span>

            @endif

        </td>

        <td class="px-6 py-5">

            <div class="flex justify-center gap-3">
            @can('attendance.edit')

<a href="{{ route('attendance.edit', $attendance->id) }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
          bg-gradient-to-r from-amber-500 to-orange-500
          hover:from-amber-600 hover:to-orange-600
          text-white font-semibold shadow-md transition">

    ✏️ Edit

</a>

@endcan

@can('attendance.delete')

<form method="POST"
      action="{{ route('attendance.destroy', $attendance->id) }}"
      onsubmit="return confirm('Delete this attendance record?')">

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
               bg-gradient-to-r from-red-500 to-rose-600
               hover:from-red-600 hover:to-rose-700
               text-white font-semibold shadow-md transition">

        🗑 Delete

    </button>

</form>

@endcan

</div>

</td>

</tr>

@endforeach

@if($attendances->isEmpty())

<tr>

<td colspan="6" class="px-6 py-16 text-center">

<div class="flex flex-col items-center">

<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">
    📋
</div>

<h3 class="text-xl font-bold text-slate-700">
    No Attendance Records Found
</h3>

<p class="text-slate-500 mt-2">
    There are currently no attendance records available.
</p>

</div>

</td>

</tr>

@endif

</tbody>

</table>

</div>

</div>

</div>

@endsection