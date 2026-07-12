@extends('layouts.app')

@section('title','Create Employee')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create Employee
        </h1>

        <p class="text-indigo-100 mt-2">
            Add a new employee to your company.
        </p>

    </div>


    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form
            action="{{ route('employees.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- First Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        First Name
                    </label>

                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

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
                        value="{{ old('last_name') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

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
                        value="{{ old('email') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

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
                        value="{{ old('phone') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

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

                    <select
                        name="department_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                {{ $department->name }}
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
                        value="{{ old('position') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

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
                        value="{{ old('salary') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                    @error('salary')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Join Date --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Join Date
                    </label>

                    <input
                        type="date"
                        name="join_date"
                        value="{{ old('join_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                    @error('join_date')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Photo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Photo
                    </label>

                    <input
                        type="file"
                        name="avatar"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                    @error('avatar')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">

                <a href="{{ route('employees.index') }}"
                   class="px-6 py-3 rounded-xl border border-slate-300
                          text-slate-700 hover:bg-slate-100 transition">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r from-indigo-600 to-violet-600
                           hover:from-indigo-700 hover:to-violet-700
                           text-white font-semibold shadow-lg transition">
                    Save Employee
                </button>

            </div>

        </form>

    </div>

</div>

@endsection