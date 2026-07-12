@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="space-y-8">



{{-- Hero --}}


<div class="relative overflow-hidden rounded-3xl
            bg-gradient-to-r
            from-indigo-600
            via-violet-600
            to-purple-700
            p-8
            shadow-2xl">



    <div class="absolute -top-16 -right-16
                w-64 h-64
                bg-white/10
                rounded-full"></div>

    <div class="absolute -bottom-20 -left-20
                w-80 h-80
                bg-white/5
                rounded-full"></div>





    <div class="relative flex flex-col lg:flex-row
                justify-between
                items-center
                gap-6">



        <div>

            <h1 class="text-4xl lg:text-5xl
                       font-black
                       text-white">

                ERP Dashboard

            </h1>

            <p class="text-indigo-100
                      text-lg
                      mt-3">

                Welcome back,
                <span class="font-bold">

                    {{ auth()->user()->name }}

                </span>

            </p>

        </div>



        <div class="w-24 h-24
                    rounded-3xl
                    bg-white/10
                    backdrop-blur-md
                    flex items-center justify-center
                    text-5xl">

            📊

        </div>



    </div>

</div>
{{-- ================= Statistics ================= --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">



    {{-- Employees --}}

    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-slate-500 text-sm">

                    Employees

                </p>

                <h2 class="text-4xl font-black mt-3 text-slate-800">
                  {{ $employees }}
                </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl
                        bg-indigo-100
                        flex items-center justify-center
                        text-3xl">

                👨‍💼

            </div>

        </div>

    </div>





    {{-- Departments --}}

    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-slate-500 text-sm">

                    Departments

                </p>

                <h2 class="text-4xl font-black mt-3 text-blue-600">
                   {{ $departments }}
                       </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl
                        bg-blue-100
                        flex items-center justify-center
                        text-3xl">

                🏢

            </div>

        </div>

    </div>





    {{-- Sales --}}

    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-slate-500 text-sm">

                    Sales

                </p>

                <h2 class="text-4xl font-black mt-3 text-green-600">
            {{ $sales }}
               </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl
                        bg-green-100
                        flex items-center justify-center
                        text-3xl">

                💰

            </div>

        </div>

    </div>





    {{-- Inventory --}}

    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-slate-500 text-sm">

                    Inventory

                </p>
                <h2 class="text-4xl font-black mt-3 text-orange-600">
    {{ $products }}
</h2>

            </div>

            <div class="w-16 h-16 rounded-2xl
                        bg-orange-100
                        flex items-center justify-center
                        text-3xl">

                📦

            </div>

        </div>

    </div>

</div>
{{-- ================= Quick Access ================= --}}

<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

    <div class="px-6 py-5 border-b bg-slate-50">

        <h2 class="text-2xl font-bold text-slate-800">

            Quick Access

        </h2>

        <p class="text-slate-500 mt-1">

            Navigate quickly to the main ERP modules.

        </p>

    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 p-6">



        <a href="{{ route('employees.index') }}"
           class="group rounded-3xl border border-slate-100
                  bg-gradient-to-br from-indigo-50 to-white
                  p-6 shadow hover:shadow-xl
                  hover:-translate-y-1 transition">

            <div class="text-4xl mb-4">

                👨‍💼

            </div>

            <h3 class="text-lg font-bold text-slate-800">

                Employees

            </h3>

            <p class="text-sm text-slate-500 mt-2">

                Manage employee records.

            </p>

        </a>




        <a href="{{ route('departments.index') }}"
           class="group rounded-3xl border border-slate-100
                  bg-gradient-to-br from-blue-50 to-white
                  p-6 shadow hover:shadow-xl
                  hover:-translate-y-1 transition">

            <div class="text-4xl mb-4">

                🏢

            </div>

            <h3 class="text-lg font-bold text-slate-800">

                Departments

            </h3>

            <p class="text-sm text-slate-500 mt-2">

                View and organize departments.

            </p>

        </a>




        <a href="{{ route('sales.index') }}"
           class="group rounded-3xl border border-slate-100
                  bg-gradient-to-br from-green-50 to-white
                  p-6 shadow hover:shadow-xl
                  hover:-translate-y-1 transition">

            <div class="text-4xl mb-4">

                💰

            </div>

            <h3 class="text-lg font-bold text-slate-800">

                Sales

            </h3>

            <p class="text-sm text-slate-500 mt-2">

                Review sales transactions.

            </p>

        </a>




        <a href="{{ route('products.index') }}"
           class="group rounded-3xl border border-slate-100
                  bg-gradient-to-br from-orange-50 to-white
                  p-6 shadow hover:shadow-xl
                  hover:-translate-y-1 transition">

            <div class="text-4xl mb-4">

                📦

            </div>

            <h3 class="text-lg font-bold text-slate-800">

                Inventory

            </h3>

            <p class="text-sm text-slate-500 mt-2">

                Products and stock management.

            </p>

        </a>



    </div>

</div>

</div>

@endsection