@extends('layouts.app')

@section('title','My Profile')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">


        <div class="flex items-center gap-5">


            <div class="w-16 h-16 rounded-3xl
                        bg-white/20
                        flex items-center justify-center
                        text-white
                        text-3xl
                        font-bold
                        backdrop-blur">

                {{ strtoupper(substr($user->name,0,1)) }}

            </div>



            <div>

                <h1 class="text-4xl font-bold text-white">

                    My Profile

                </h1>


                <p class="text-indigo-100 mt-2">

                    Manage your personal information and account settings.

                </p>


            </div>


        </div>


    </div>




    {{-- Profile Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        @if(session('success'))

            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl">

                {{ session('success') }}

            </div>

        @endif



        <form method="POST"
              action="{{ route('profile.update') }}"
              class="space-y-6">


            @csrf
            @method('PATCH')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Name --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">

                        Full Name

                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$user->name) }}"
                        placeholder="Example: Ahmed Mohammed"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>




                {{-- Email --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">

                        Email Address

                    </label>


                    <input
                        type="email"
                        name="email"
                        value="{{ old('email',$user->email) }}"
                        placeholder="Example: admin@company.com"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>





                {{-- Phone --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">

                        Phone

                    </label>


                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone',$user->phone) }}"
                        placeholder="Example: +963 999 999999"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>




                {{-- User ID --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">

                        Account ID

                    </label>


                    <input
                        type="text"
                        disabled
                        value="#{{ $user->id }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3 bg-slate-100">


                </div>



            </div>
            {{-- Security Section --}}
            <div class="pt-6 border-t border-slate-200">

                <h2 class="text-xl font-bold text-slate-800 mb-5">

                    Security Settings

                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- Password --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">

                            New Password

                        </label>


                        <input
                            type="password"
                            name="password"
                            placeholder="Leave empty to keep current password"
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

                        <label class="block mb-2 text-sm font-semibold text-slate-700">

                            Confirm Password

                        </label>


                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full rounded-xl border border-slate-300 px-5 py-3
                                   focus:ring-4 focus:ring-indigo-100
                                   focus:border-indigo-500 outline-none">


                    </div>


                </div>


            </div>



            {{-- Account Info --}}
            <div class="pt-6 border-t border-slate-200">


                <h2 class="text-xl font-bold text-slate-800 mb-5">

                    Account Information

                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">

                            Role

                        </label>


                        <input
                            type="text"
                            disabled
                            value="{{ $user->roles->first()?->name ?? 'No Role' }}"
                            class="w-full rounded-xl border border-slate-300 px-5 py-3 bg-slate-100">


                    </div>



                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">

                            Created At

                        </label>


                        <input
                            type="text"
                            disabled
                            value="{{ $user->created_at->format('Y-m-d') }}"
                            class="w-full rounded-xl border border-slate-300 px-5 py-3 bg-slate-100">


                    </div>


                </div>


            </div>




            {{-- Buttons --}}
            <div class="flex justify-between items-center pt-6 border-t border-slate-200">


                <div class="text-sm text-slate-400">

                    Profile ID:

                    <span class="font-semibold text-slate-600">

                        #{{ $user->id }}

                    </span>

                </div>



                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r
                           from-indigo-600
                           via-violet-600
                           to-purple-700
                           text-white
                           font-semibold
                           shadow-lg
                           hover:scale-105
                           transition">


                    Save Changes


                </button>


            </div>


        </form>


    </div>


</div>


@endsection