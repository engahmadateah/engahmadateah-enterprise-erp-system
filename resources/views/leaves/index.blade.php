@extends('layouts.app')

@section('title', 'Leave Requests')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Leave Requests
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Review, approve, and manage employee leave requests from one modern dashboard.
                </p>

            </div>

            <div class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                        bg-white text-indigo-700 font-semibold shadow-xl">

                <span class="text-xl">🌴</span>

                Employee Leaves

            </div>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Requests
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-slate-800">
                        {{ $leaves->count() }}
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
                        Approved
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $leaves->where('status','approved')->count() }}
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
                        Pending
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-amber-600">
                        {{ $leaves->where('status','pending')->count() }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center text-3xl">
                    ⏳
                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Rejected
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $leaves->where('status','rejected')->count() }}
                    </h2>

                </div>

                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    ❌
                </div>

            </div>

        </div>

    </div>
    {{-- Leave Requests Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Leave Requests
            </h2>

            <p class="text-slate-500 mt-1">
                List of all employee leave requests.
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
                            Leave Type
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            From
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            To
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Days
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

                    @forelse($leaves as $leave)

                    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">

                                    {{ strtoupper(substr($leave->employee->first_name,0,1)) }}

                                </div>

                                <div>

                                    <div class="font-bold text-slate-800">

                                        {{ $leave->employee->first_name }}
                                        {{ $leave->employee->last_name }}

                                    </div>

                                    <div class="text-sm text-slate-500">

                                        Employee

                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 text-slate-700">

                            {{ ucfirst($leave->leave_type_id) }}

                        </td>

                        <td class="px-6 py-5 font-medium text-slate-700">

                            {{ $leave->start_date }}

                        </td>

                        <td class="px-6 py-5 text-slate-700">

                            {{ $leave->end_date }}

                        </td>

                        <td class="px-6 py-5 font-semibold text-slate-700">

                            {{ $leave->days }}

                        </td>

                        <td class="px-6 py-5">
                        @if($leave->status == 'approved')

<span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-semibold">
    ✅ Approved
</span>

@elseif($leave->status == 'rejected')

<span class="inline-flex items-center px-4 py-2 rounded-xl bg-red-100 text-red-700 font-semibold">
    ❌ Rejected
</span>

@else

<span class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-semibold">
    ⏳ Pending
</span>

@endif

</td>

<td class="px-6 py-5">

<div class="flex justify-center gap-3">

@if($leave->status == 'pending')

<form method="POST"
      action="{{ route('leaves.approve',$leave->id) }}">

    @csrf

    <button type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                   bg-gradient-to-r from-green-500 to-emerald-600
                   hover:from-green-600 hover:to-emerald-700
                   text-white font-semibold shadow-md transition">

        ✅ Approve

    </button>

</form>

<form method="POST"
      action="{{ route('leaves.reject',$leave->id) }}">

    @csrf

    <button type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                   bg-gradient-to-r from-red-500 to-rose-600
                   hover:from-red-600 hover:to-rose-700
                   text-white font-semibold shadow-md transition">

        ❌ Reject

    </button>

</form>

@endif

</div>

</td>

</tr>

@empty

<tr>

<td colspan="7" class="px-6 py-16 text-center">

<div class="flex flex-col items-center">

<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">
    🌴
</div>

<h3 class="text-xl font-bold text-slate-700">
    No Leave Requests Found
</h3>

<p class="text-slate-500 mt-2">
    There are currently no leave requests available.
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