<header class="h-20 bg-white/95 backdrop-blur-xl
               border-b border-slate-200
               shadow-sm">

    <div class="h-full px-8
                flex items-center justify-between">



        {{-- Left Side --}}

        <div class="flex items-center gap-5">



            <div class="w-14 h-14 rounded-3xl
                        bg-gradient-to-br
                        from-indigo-600
                        via-violet-600
                        to-purple-700
                        flex items-center justify-center
                        text-white
                        text-2xl
                        shadow-xl">

                🏢

            </div>





            <div>

                <h1 class="text-2xl font-black text-slate-800">

                    ERP Dashboard

                </h1>

                <p class="text-sm text-slate-500 mt-1">

                    Welcome back,
                    <span class="font-semibold">

                        {{ auth()->user()->name }}

                    </span>

                </p>

            </div>



        </div>





        {{-- Right Side --}}

        <div class="flex items-center gap-5">
        {{-- User Info --}}

<div class="flex items-center gap-4">


    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-4 group">


        <div class="w-12 h-12 rounded-2xl
                    bg-gradient-to-br
                    from-indigo-600
                    to-violet-600
                    flex items-center justify-center
                    text-white
                    font-bold
                    text-lg
                    shadow-lg
                    group-hover:scale-105
                    transition">

            {{ strtoupper(substr(auth()->user()->name,0,1)) }}

        </div>




        <div class="text-right">


            <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition">

                {{ auth()->user()->name }}

            </div>


        </div>


    </a>


</div>
    {{-- Logout --}}

<form method="POST"
      action="{{ route('logout') }}">

    @csrf

    <button
        type="submit"
        class="inline-flex items-center gap-2
               px-5 py-3
               rounded-2xl
               bg-gradient-to-r
               from-red-500
               to-rose-600
               text-white
               font-semibold
               shadow-lg
               hover:from-red-600
               hover:to-rose-700
               hover:scale-105
               transition">

        🚪 Logout

    </button>

</form>

</div>

</header>