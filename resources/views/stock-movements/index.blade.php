@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')

<div class="space-y-8">


    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">


        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>




        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">



            <div>



                <h1 class="text-4xl lg:text-5xl font-bold text-white">

                    Stock Movements

                </h1>




                <p class="text-indigo-100 mt-3 text-lg">

                    Track inventory changes, incoming and outgoing stock movements with a modern dashboard.

                </p>



            </div>




        </div>



    </div>




    {{-- Statistics --}}


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">





        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">



            <div class="flex justify-between items-center">



                <div>



                    <p class="text-slate-500 text-sm">

                        Total Movements

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">

                        {{ $movements->count() }}

                    </h2>



                </div>




                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

                    📦

                </div>




            </div>



        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">



            <div class="flex justify-between items-center">



                <div>



                    <p class="text-slate-500 text-sm">

                        Stock In

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-green-600">

                        {{ $movements->where('type','in')->count() }}

                    </h2>



                </div>




                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

                    📥

                </div>




            </div>



        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">



            <div class="flex justify-between items-center">



                <div>



                    <p class="text-slate-500 text-sm">

                        Stock Out

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-red-600">

                        {{ $movements->where('type','out')->count() }}

                    </h2>



                </div>




                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">

                    📤

                </div>




            </div>



        </div>





    </div>
    {{-- Stock Movements Table --}}

<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">



        <h2 class="text-2xl font-bold text-slate-800">

            Movement Records

        </h2>




        <p class="text-slate-500 mt-1">

            Complete history of stock in and stock out operations.

        </p>



    </div>





    <div class="overflow-x-auto" dir="ltr">



        <table class="min-w-full">





            <thead class="bg-slate-100">



                <tr>



                    <th class="px-6 py-4 text-left font-semibold">

                        Product

                    </th>



                    <th class="px-6 py-4 text-left font-semibold">

                        Type

                    </th>



                    <th class="px-6 py-4 text-left font-semibold">

                        Quantity

                    </th>



                    <th class="px-6 py-4 text-left font-semibold">

                        User

                    </th>



                    <th class="px-6 py-4 text-left font-semibold">

                        Date

                    </th>



                </tr>



            </thead>






            <tbody>




                @forelse($movements as $move)




                <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">





                    <td class="px-6 py-5">



                        <div class="flex items-center gap-4">



                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-2xl">


                                📦


                            </div>





                            <div>




                                <div class="font-bold text-slate-800">


                                    {{ $move->product->name }}


                                </div>





                                <div class="text-sm text-slate-500">


                                    Stock Item


                                </div>





                            </div>





                        </div>




                    </td>






                    <td class="px-6 py-5">



                        @if($move->type == 'in')



                            <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-bold">


                                📥 IN


                            </span>




                        @else




                            <span class="inline-flex items-center px-4 py-2 rounded-xl bg-red-100 text-red-700 font-bold">


                                📤 OUT


                            </span>




                        @endif




                    </td>






                    <td class="px-6 py-5">



                        <span class="font-bold text-slate-700">


                            {{ $move->quantity }}


                        </span>




                    </td>






                    <td class="px-6 py-5 text-slate-700">


                    {{ $move->user->name ?? '-' }}



                    </td>






                    <td class="px-6 py-5 text-slate-700">

                        {{ $move->created_at }}


                    </td>


                </tr>
                @empty


<tr>


    <td colspan="5" class="px-6 py-16 text-center">



        <div class="flex flex-col items-center">



            <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">

                📦

            </div>





            <h3 class="text-xl font-bold text-slate-700">


                No Stock Movements Found


            </h3>





            <p class="text-slate-500 mt-2">


                There are currently no inventory movement records available.


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