<x-guest-layout>

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br
            from-slate-900
            via-indigo-900
            to-purple-900
            px-6">


    <div class="w-full max-w-md">


        <div class="bg-white/95
                    backdrop-blur-xl
                    rounded-3xl
                    shadow-2xl
                    p-8">



            {{-- Logo --}}

            <div class="text-center mb-8">


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
                           mt-5">

                    Reset Password

                </h1>


                <p class="text-slate-500 mt-3">

                    Recover your ERP account access

                </p>


            </div>





            {{-- Message --}}

            <div class="mb-6 text-sm text-slate-600 leading-relaxed">


                {{ __('Forgot your password? No problem. Just enter your email address and we will send you a password reset link.') }}


            </div>





            {{-- Session Status --}}

            <x-auth-session-status
                class="mb-4"
                :status="session('status')" />





            <form method="POST"
                  action="{{ route('password.email') }}">

                @csrf




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
                        autofocus />



                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2" />


                </div>





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
                               shadow-lg
                               hover:from-indigo-700
                               hover:to-purple-800
                               transition">


                        Send Reset Link


                    </button>


                </div>



            </form>


        </div>




        <div class="text-center mt-6 text-sm text-slate-300">


            © {{ date('Y') }} ERP System.
            All rights reserved.


        </div>


    </div>



</div>


</x-guest-layout>