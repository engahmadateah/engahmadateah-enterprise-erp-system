@extends('layouts.app')

@section('title','Create User')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create User
        </h1>

        <p class="text-indigo-100 mt-2">
            Add a new user and assign a role.
        </p>

    </div>


    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form action="{{ route('users.store') }}"
              method="POST"
              class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Full Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email Address
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
                        Phone Number
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


                {{-- Role --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        User Role
                    </label>

                    <select
                        name="role"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                        @foreach($roles as $role)
                            <option
                                value="{{ $role->name }}"
                                {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('role')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">

                    @error('password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">
                </div>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-6 border-t">

                <a href="{{ route('users.index') }}"
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
                    Save User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection