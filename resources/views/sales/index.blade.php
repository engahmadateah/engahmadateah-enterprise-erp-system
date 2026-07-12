@extends('layouts.app')

@section('title','Sales')

@section('content')

<div class="space-y-8">


    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">


        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>




        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">



            <div>



                <h1 class="text-4xl lg:text-5xl font-bold text-white">

                    Sales

                </h1>




                <p class="text-indigo-100 mt-3 text-lg">

                    Manage customer sales, invoices, products, and warehouse transactions from one modern dashboard.

                </p>



            </div>






            <a href="{{ route('sales.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">



                <span class="text-xl">🛒</span>


                Add Sale



            </a>




        </div>



    </div>





    {{-- Statistics --}}


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">





        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">



                <div>


                    <p class="text-slate-500 text-sm">

                        Total Sales

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">

                        {{ $sales->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

                    🧾

                </div>



            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">



                <div>


                    <p class="text-slate-500 text-sm">

                        Total Quantity

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-blue-600">

                        {{ $sales->sum('quantity') }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

                    📦

                </div>



            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">



                <div>


                    <p class="text-slate-500 text-sm">

                        Total Revenue

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-green-600">

                        {{ number_format($sales->sum('total'),2) }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

                    💰

                </div>



            </div>


        </div>





    </div>
    {{-- Sales Table --}}

<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">



        <h2 class="text-2xl font-bold text-slate-800">

            Sales Records

        </h2>




        <p class="text-slate-500 mt-1">

            Complete list of customer sales and generated invoices.

        </p>



    </div>






    <div class="overflow-x-auto" dir="ltr">



        <table class="min-w-full">





            <thead class="bg-slate-100">



                <tr>



                    <th class="px-6 py-4 text-left font-semibold">
                        Invoice
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Customer
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Product
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Warehouse
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Qty
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Unit Price
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Total
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        User
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Date
                    </th>



                    <th class="px-6 py-4 text-center font-semibold">
                        Actions
                    </th>



                </tr>



            </thead>






            <tbody>




                @forelse($sales as $sale)





                <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">





                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-bold">


                            🧾 {{ $sale->invoice_number }}


                        </span>



                    </td>






                    <td class="px-6 py-5">



                        <div class="font-bold text-slate-800">


                            {{ $sale->customer?->name ?? 'Walk-in Customer' }}


                        </div>




                    </td>






                    <td class="px-6 py-5">



                        <div class="flex items-center gap-3">



                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-xl">


                                📦


                            </div>



                            <span class="font-semibold text-slate-700">


                                {{ $sale->product?->name ?? '-' }}


                            </span>



                        </div>



                    </td>






                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-purple-100 text-purple-700 font-semibold">


                            🏭 {{ $sale->warehouse?->name ?? '-' }}


                        </span>



                    </td>






                    <td class="px-6 py-5 font-bold text-slate-700">


                        {{ $sale->quantity }}


                    </td>






                    <td class="px-6 py-5 text-slate-700">


                        {{ number_format($sale->unit_price,2) }}


                    </td>






                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-bold">


                            💰 {{ number_format($sale->total,2) }}


                        </span>



                    </td>
                    <td class="px-6 py-5 text-slate-700">


{{ $sale->user?->name ?? '-' }}



</td>






<td class="px-6 py-5 text-slate-700">


{{ $sale->created_at->format('Y-m-d') }}



</td>






<td class="px-6 py-5">


<div class="flex justify-center">



    <a href="{{ route('sales.invoice',$sale->id) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
              bg-gradient-to-r from-green-500 to-emerald-600
              hover:from-green-600 hover:to-emerald-700
              text-white font-semibold shadow-md transition">



        🧾 Invoice



    </a>



</div>



</td>





</tr>





@empty




<tr>



<td colspan="10" class="px-6 py-16 text-center">





<div class="flex flex-col items-center">





    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">


        🛒


    </div>







    <h3 class="text-xl font-bold text-slate-700">


        No Sales Found


    </h3>







    <p class="text-slate-500 mt-2">


        There are currently no sales records available.


    </p>





</div>





</td>



</tr>




@endforelse






</tbody>





</table>





</div>




</div>





{{-- Pagination --}}


<div class="mt-4">


{{ $sales->links() }}



</div>





</div>



@endsection