@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Employee
        </h1>

        <p class="text-orange-100 mt-2">
            Update the employee information.
        </p>

    </div>

    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form method="POST"
              action="{{ route('employees.update', $employee->id) }}"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Employee No --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Employee No
                    </label>

                    <input
                        type="text"
                        name="employee_no"
                        value="{{ old('employee_no', $employee->employee_no) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('employee_no')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- First Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        First Name
                    </label>

                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name', $employee->first_name) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('first_name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Last Name
                    </label>

                    <input
                        type="text"
                        name="last_name"
                        value="{{ old('last_name', $employee->last_name) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('last_name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $employee->email) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('email')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Phone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $employee->phone) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Department --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Department
                    </label>

                    <select name="department_id"
                            class="w-full rounded-xl border border-slate-300 px-5 py-3
                                   focus:ring-4 focus:ring-orange-100
                                   focus:border-orange-500 outline-none transition">

                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('department_id')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Position --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Position
                    </label>

                    <input
                        type="text"
                        name="position"
                        value="{{ old('position', $employee->position) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('position')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Salary --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Salary
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="salary"
                        value="{{ old('salary', $employee->salary) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('salary')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        Employee Status
                    </label>

                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-green-600 focus:ring-green-500">

                        <span class="text-slate-700 font-medium">
                            Active Employee
                        </span>
                    </label>

                    @error('is_active')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-6 border-t">

                <a href="{{ route('employees.index') }}"
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
                    Update Employee
                </button>

            </div>

        </form>

    </div>

</div>

@endsection