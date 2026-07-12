@extends('layouts.app')

@section('title','Employees')

@section('content')

@php
    $employeeCollection = $employees->getCollection();
    $activeEmployees = $employeeCollection->where('is_active', true)->count();
    $inactiveEmployees = $employeeCollection->where('is_active', false)->count();
    $departmentCount = $employeeCollection->pluck('department_id')->filter()->unique()->count();
@endphp

<div class="space-y-8">

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>
                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Employees
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Manage employees, departments, positions, and account status from one modern dashboard.
                </p>
            </div>

            @can('employees.create')
                <a href="{{ route('employees.create') }}"
                   class="bg-white text-indigo-700 hover:bg-indigo-50 transition px-7 py-4 rounded-2xl font-semibold shadow-xl">
                    + Add Employee
                </a>
            @endcan

        </div>

    </div>
  

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 hover:shadow-2xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm">
                        Total Employees
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-slate-800">
                        {{ $employees->total() }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    👥
                </div>
            </div>
        </div>


        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 hover:shadow-2xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm">
                        Active On Page
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $activeEmployees }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    ✅
                </div>
            </div>
        </div>


        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 hover:shadow-2xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm">
                        Inactive On Page
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $inactiveEmployees }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    ❌
                </div>
            </div>
        </div>


        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6 hover:shadow-2xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-500 text-sm">
                        Departments On Page
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-amber-600">
                        {{ $departmentCount }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center text-3xl">
                    🏢
                </div>
            </div>
        </div>

    </div>

    {{-- Search --}}
<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-5">

    <form action="{{ route('employees.index') }}" method="GET">

        <div class="flex flex-col lg:flex-row gap-4">

            <div class="relative flex-1">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, employee no, email, phone, department, or position..."
                    class="w-full pl-14 pr-5 py-4 rounded-2xl border border-slate-200
                           focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500
                           outline-none transition">

            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="px-7 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600
                           hover:from-indigo-700 hover:to-violet-700
                           text-white font-semibold shadow-lg transition">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('employees.index') }}"
                       class="px-7 py-4 rounded-2xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 font-semibold transition">
                        Clear
                    </a>
                @endif

            </div>

        </div>

    </form>

</div>
    {{-- Directory Header --}}
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-5">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Employee Directory
                </h2>

                <p class="mt-1 text-slate-500">
                    Showing {{ $employees->count() }} employees on this page
                </p>
            </div>

            <div class="inline-flex w-fit items-center rounded-full bg-indigo-50 px-5 py-2 text-sm font-semibold text-indigo-700">
                Page {{ $employees->currentPage() }} of {{ $employees->lastPage() }}
            </div>

        </div>

    </div>


    {{-- Employee Cards --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-7">

        @forelse($employees as $employee)

            <div class="group bg-white rounded-3xl border border-slate-200 shadow-lg hover:shadow-2xl hover:border-indigo-300 hover:-translate-y-1 transition duration-300 overflow-hidden">

                <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 h-2"></div>

                <div class="p-6">

                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-5">

                        <div class="flex items-center gap-4">

                            @if($employee->avatar)
                                <img src="{{ asset('storage/'.$employee->avatar) }}"
                                     alt="{{ $employee->first_name }} {{ $employee->last_name }}"
                                     class="w-16 h-16 rounded-2xl object-cover shadow-lg ring-4 ring-indigo-50">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg">
                                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                </div>
                            @endif

                            <div>
                                <h2 class="text-2xl font-bold text-slate-800">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </h2>

                                <p class="text-slate-500 mt-1">
                                    ID #{{ $employee->id }}
                                </p>
                            </div>

                        </div>

                        @if($employee->is_active)
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold text-sm">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 font-semibold text-sm">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                Inactive
                            </span>
                        @endif

                    </div>


                    {{-- Information --}}
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-5">

                        <div>
                            <p class="text-sm text-slate-400">
                                Employee No
                            </p>

                            <div class="mt-2 inline-flex px-4 py-2 rounded-xl bg-slate-100 font-semibold text-slate-700">
                                {{ $employee->employee_no }}
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-slate-400">
                                Department
                            </p>

                            <p class="mt-2 text-slate-700 font-semibold">
                                {{ $employee->department->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-400">
                                Position
                            </p>

                            <p class="mt-2 text-slate-700 font-semibold">
                                {{ $employee->position }}
                            </p>
                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="mt-8 pt-6 border-t flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

                        <span class="text-sm text-slate-400">
                            Employee Record
                        </span>

                        <div class="flex gap-3">

                            @can('employees.edit')
                                <a href="{{ route('employees.edit', $employee->id) }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition">
                                    ✏️ Edit
                                </a>
                            @endcan

                            @can('employees.delete')
                                <form method="POST"
                                      action="{{ route('employees.destroy', $employee->id) }}"
                                      onsubmit="return confirm('Delete this employee?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white transition">
                                        🗑 Delete
                                    </button>
                                </form>
                            @endcan

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full">

                <div class="bg-white rounded-3xl shadow-xl p-20 text-center">

                    <div class="text-7xl mb-6">
                        👥
                    </div>

                    <h2 class="text-3xl font-bold text-slate-700">
                        No Employees Found
                    </h2>

                    <p class="mt-4 text-slate-500">
                        There are currently no employees available.
                    </p>

                    @can('employees.create')
                        <a href="{{ route('employees.create') }}"
                           class="inline-block mt-8 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white">
                            + Create First Employee
                        </a>
                    @endcan

                </div>

            </div>

        @endforelse

    </div>


    @if($employees->hasPages())
        <div class="pt-4">
            {{ $employees->links() }}
        </div>
    @endif

</div>

@endsection