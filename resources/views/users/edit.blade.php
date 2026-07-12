@extends('layouts.app')

@section('title','Edit User')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit User
        </h1>

        <p class="text-orange-100 mt-2">
            Update account information, role, and status.
        </p>

    </div>


    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">

        <form action="{{ route('users.update', $user) }}"
              method="POST"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Full Name --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
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
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Phone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Role --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        User Role
                    </label>

                    <select
                        name="role"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                        @foreach($roles as $role)
                            <option
                                value="{{ $role->name }}"
                                @selected(old('role', $user->roles->first()?->name) == $role->name)>
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
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Leave blank to keep current password"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">

                    @error('password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Status --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Account Status
                    </label>

                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $user->is_active))
                            class="w-5 h-5 rounded text-green-600 focus:ring-green-500">

                        <span class="text-slate-700 font-medium">
                            Active Account
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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">

                <div class="text-sm text-slate-400">
                    User ID:
                    <span class="font-semibold text-slate-600">
                        #{{ $user->id }}
                    </span>
                </div>

                <div class="flex justify-end gap-4">

                    <a href="{{ route('users.index') }}"
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
                        Update User
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection