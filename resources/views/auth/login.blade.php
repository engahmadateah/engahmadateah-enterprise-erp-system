<x-guest-layout>

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br
            from-slate-900
            via-indigo-900
            to-purple-900
            px-6">


    <div class="w-full max-w-6xl
                grid grid-cols-1
                lg:grid-cols-2
                gap-10
                items-center">


        {{-- LEFT SIDE BRAND --}}

        <div class="text-white space-y-8 hidden lg:block">


            <div class="flex items-center gap-5">


                <div class="w-20 h-20
                            rounded-3xl
                            bg-white/10
                            backdrop-blur-xl
                            border border-white/20
                            flex items-center justify-center
                            text-4xl
                            font-black
                            shadow-2xl">

                    ERP

                </div>


                <div>

                    <h1 class="text-5xl font-black tracking-wide">

                        ERP System

                    </h1>


                    <p class="text-indigo-200 mt-2 text-lg">

                        Enterprise Resource Planning

                    </p>


                </div>


            </div>





            <div>


                <h2 class="text-4xl font-bold leading-tight">

                    Manage your business
                    <br>
                    smarter and faster

                </h2>


                <p class="mt-5 text-slate-300 text-lg max-w-xl">

                    Complete business management platform
                    including Human Resources,
                    Payroll, Inventory, Accounting and IT Support.

                </p>


            </div>





            <div class="grid grid-cols-2 gap-5 max-w-lg">


                <div class="bg-white/10
                            border border-white/10
                            rounded-2xl
                            p-5
                            backdrop-blur">


                    <h3 class="font-bold text-xl">

                        HR

                    </h3>


                    <p class="text-sm text-slate-300 mt-2">

                        Employees and attendance management

                    </p>


                </div>





                <div class="bg-white/10
                            border border-white/10
                            rounded-2xl
                            p-5
                            backdrop-blur">


                    <h3 class="font-bold text-xl">

                        Payroll

                    </h3>


                    <p class="text-sm text-slate-300 mt-2">

                        Salary and financial control

                    </p>


                </div>


            </div>


        </div>




        {{-- LOGIN CARD --}}


        <div class="bg-white/95
                    backdrop-blur-xl
                    rounded-3xl
                    shadow-2xl
                    p-8
                    lg:p-10">



            {{-- Mobile Logo --}}

            <div class="lg:hidden text-center mb-8">


                <div class="inline-flex
                            w-20 h-20
                            rounded-3xl
                            bg-gradient-to-br
                            from-indigo-600
                            to-purple-700
                            items-center
                            justify-center
                            text-white
                            text-3xl
                            font-black
                            shadow-xl">

                    ERP

                </div>



                <h1 class="text-3xl
                           font-black
                           text-slate-800
                           mt-4">

                    ERP System

                </h1>


            </div>





            <div class="mb-8">


                <h2 class="text-3xl
                           font-black
                           text-slate-800">

                    Welcome Back

                </h2>


                <p class="text-slate-500 mt-2">

                    Login to access your ERP dashboard

                </p>


            </div>




            {{-- Session Status --}}

            <x-auth-session-status
                class="mb-4"
                :status="session('status')" />





            <form method="POST"
                  action="{{ route('login') }}">

                @csrf
                {{-- EMAIL --}}

<div>

    <x-input-label
        for="email"
        :value="__('Email')"
        class="text-slate-700 font-semibold"/>


    <x-text-input
        id="email"
        class="block mt-2 w-full
               rounded-xl
               border-slate-300
               focus:border-indigo-500
               focus:ring-indigo-500"
        type="email"
        name="email"
        :value="old('email')"
        required
        autofocus
        autocomplete="username" />


    <x-input-error
        :messages="$errors->get('email')"
        class="mt-2" />

</div>





{{-- PASSWORD --}}

<div class="mt-5">

    <x-input-label
        for="password"
        :value="__('Password')"
        class="text-slate-700 font-semibold"/>


    <x-text-input
        id="password"
        class="block mt-2 w-full
               rounded-xl
               border-slate-300
               focus:border-indigo-500
               focus:ring-indigo-500"
        type="password"
        name="password"
        required
        autocomplete="current-password" />


    <x-input-error
        :messages="$errors->get('password')"
        class="mt-2" />

</div>





{{-- REMEMBER ME --}}

<div class="flex items-center justify-between mt-6">


    <label for="remember_me"
           class="inline-flex items-center">


        <input id="remember_me"
               type="checkbox"
               class="rounded
                      border-gray-300
                      text-indigo-600
                      shadow-sm
                      focus:ring-indigo-500"
               name="remember">


        <span class="ms-2 text-sm text-slate-600">

            {{ __('Remember me') }}

        </span>


    </label>





    @if (Route::has('password.request'))

    <a class="text-sm
              text-indigo-600
              hover:text-indigo-800
              font-semibold"
       href="{{ route('password.request') }}">

        Forgot password?

    </a>


    @endif


</div>





{{-- LOGIN BUTTON --}}

<div class="mt-8">

    <button
        type="submit"
        class="w-full
               py-4
               rounded-xl
               bg-gradient-to-r
               from-indigo-600
               to-purple-700
               text-white
               font-bold
               text-lg
               shadow-lg
               hover:from-indigo-700
               hover:to-purple-800
               transition">

        Login

    </button>

</div>



</form>


</div>



</div>



{{-- Footer --}}

<div class="fixed bottom-6 left-0 right-0 text-center">

<p class="text-sm text-slate-300">

© {{ date('Y') }} ERP System.
All rights reserved.

</p>

</div>



</div>


</x-guest-layout>