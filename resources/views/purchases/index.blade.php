@extends('layouts.app')

@section('title','Purchases')

@section('content')

<div class="space-y-8">


    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">


        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>



        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">



            <div>



                <h1 class="text-4xl lg:text-5xl font-bold text-white">

                    Purchases

                </h1>




                <p class="text-indigo-100 mt-3 text-lg">

                    Manage supplier purchases, products, warehouses, and inventory transactions from one modern dashboard.

                </p>



            </div>





            <a href="{{ route('purchases.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">



                <span class="text-xl">🛒</span>


                Add Purchase



            </a>




        </div>



    </div>





    {{-- Statistics --}}


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">





        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Total Purchases

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">

                        {{ $purchases->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

                    🛒

                </div>


            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Total Quantity

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-green-600">

                        {{ $purchases->sum('quantity') }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

                    📦

                </div>


            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Total Amount

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-purple-600">

                        {{ number_format($purchases->sum('total'),2) }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">

                    💰

                </div>


            </div>


        </div>




    </div>
    {{-- Purchases Table --}}

<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">



        <h2 class="text-2xl font-bold text-slate-800">

            Purchase Records

        </h2>




        <p class="text-slate-500 mt-1">

            List of all supplier purchases and inventory entries.

        </p>



    </div>






    <div class="overflow-x-auto" dir="ltr">



        <table class="min-w-full">





            <thead class="bg-slate-100">



                <tr>



                    <th class="px-6 py-4 text-left font-semibold">
                        #
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Supplier
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Product
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Warehouse
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Quantity
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Unit Price
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Total
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Date
                    </th>



                </tr>



            </thead>






            <tbody>




                @forelse($purchases as $purchase)





                <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">





                    <td class="px-6 py-5 font-bold text-slate-700">


                        #{{ $purchase->id }}


                    </td>






                    <td class="px-6 py-5">



                        <div class="flex items-center gap-3">



                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-xl">


                                🏢


                            </div>



                            <span class="font-bold text-slate-800">


                                {{ $purchase->supplier->name }}


                            </span>



                        </div>




                    </td>






                    <td class="px-6 py-5">


                        <div class="flex items-center gap-3">


                            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-xl">


                                📦


                            </div>



                            <span class="font-semibold text-slate-700">


                                {{ $purchase->product->name }}


                            </span>



                        </div>



                    </td>






                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-purple-100 text-purple-700 font-semibold">


                            🏭 {{ $purchase->warehouse->name }}


                        </span>



                    </td>






                    <td class="px-6 py-5 font-bold text-slate-700">


                        {{ $purchase->quantity }}


                    </td>






                    <td class="px-6 py-5 text-slate-700">


                        {{ number_format($purchase->unit_price,2) }}


                    </td>






                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-bold">


                            💰 {{ number_format($purchase->total,2) }}


                        </span>



                    </td>






                    <td class="px-6 py-5 text-slate-700">


                        {{ $purchase->purchase_date }}


                    </td>


                </tr>
                @empty


<tr>


    <td colspan="8" class="px-6 py-16 text-center">



        <div class="flex flex-col items-center">



            <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">

                🛒

            </div>





            <h3 class="text-xl font-bold text-slate-700">


                No Purchases Found


            </h3>





            <p class="text-slate-500 mt-2">


                There are currently no purchase records available.


            </p>




        </div>




    </td>



</tr>



@endforelse




</tbody>




</table>




</div>




</div>




</div>



@endsection