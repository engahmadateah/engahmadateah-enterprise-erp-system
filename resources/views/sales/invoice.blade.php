@extends('layouts.app')

@section('title','Invoice')

@section('content')

<div class="max-w-5xl mx-auto p-6 space-y-6">


    {{-- Invoice Container --}}

    <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">



        {{-- Header --}}

        <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8">



            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full"></div>

            <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>





            <div class="relative flex flex-col md:flex-row justify-between gap-6">





                <div>



                    <h1 class="text-4xl font-bold text-white">

                        INVOICE

                    </h1>



                    <p class="text-indigo-100 mt-2 text-lg">

                        {{ $sale->invoice_number }}

                    </p>



                </div>






                <div class="text-white md:text-right">



                    <p class="mb-2">

                        <span class="font-semibold">
                            Date:
                        </span>

                        {{ $sale->created_at->format('Y-m-d H:i') }}

                    </p>





                    <p>

                        <span class="font-semibold">
                            Sales User:
                        </span>

                        {{ $sale->user->name ?? '-' }}

                    </p>



                </div>





            </div>




        </div>





        {{-- Information Cards --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-8">



            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">


                <div class="flex items-center gap-3 mb-4">


                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">

                        👤

                    </div>


                    <h3 class="font-bold text-slate-800 text-lg">

                        Customer

                    </h3>


                </div>
                <p class="font-semibold text-slate-800">

{{ $sale->customer->name ?? 'Walk-in Customer' }}

</p>



<p class="text-slate-600 mt-1">

{{ $sale->customer->phone ?? '-' }}

</p>



<p class="text-slate-600">

{{ $sale->customer->email ?? '-' }}

</p>



</div>






<div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">


<div class="flex items-center gap-3 mb-4">


<div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">

    🏢

</div>


<h3 class="font-bold text-slate-800 text-lg">

    Warehouse

</h3>


</div>



<p class="font-semibold text-slate-800">

{{ $sale->warehouse->name ?? '-' }}

</p>



</div>







<div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">


<div class="flex items-center gap-3 mb-4">


<div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">

    🧾

</div>


<h3 class="font-bold text-slate-800 text-lg">

    Invoice Details

</h3>


</div>




<p class="text-slate-600">

Invoice No:

<span class="font-semibold text-slate-800">

    {{ $sale->invoice_number }}

</span>

</p>



<p class="text-slate-600 mt-1">

Status:

<span class="font-semibold text-green-600">

    Completed

</span>

</p>



</div>




</div>






{{-- Product Table --}}


<div class="px-8 pb-8">



<div class="rounded-2xl overflow-hidden border border-slate-200" dir="ltr">

<table class="w-full">



<thead class="bg-slate-100">



    <tr>



        <th class="px-6 py-4 text-left font-bold text-slate-700">

            Product

        </th>



        <th class="px-6 py-4 text-left font-bold text-slate-700">

            Quantity

        </th>



        <th class="px-6 py-4 text-left font-bold text-slate-700">

            Unit Price

        </th>



        <th class="px-6 py-4 text-left font-bold text-slate-700">

            Total

        </th>



    </tr>



</thead>




<tbody>



    <tr class="border-t">



        <td class="px-6 py-5 font-semibold text-slate-800">

            {{ $sale->product->name }}


        </td>



        <td class="px-6 py-5 text-slate-700">

            {{ $sale->quantity }}


        </td>



        <td class="px-6 py-5 text-slate-700">

            {{ number_format($sale->unit_price,2) }}


        </td>



        <td class="px-6 py-5 font-bold text-green-600">

            {{ number_format($sale->total,2) }}


        </td>



    </tr>



</tbody>



</table>



</div>
{{-- Total --}}


<div class="mt-8 flex justify-end">



    <div class="bg-green-50 border border-green-100 rounded-2xl px-8 py-5 text-right">



        <p class="text-slate-500 text-sm mb-2">

            Grand Total

        </p>




        <h2 class="text-4xl font-bold text-green-600">


            {{ number_format($sale->total,2) }}


        </h2>



    </div>



</div>






{{-- Actions --}}


<div class="mt-8 flex flex-wrap gap-4">





    <a href="{{ route('sales.index') }}"
       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
              bg-slate-600 hover:bg-slate-700
              text-white font-semibold shadow-md transition">


        ⬅️ Back


    </a>






    <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                   bg-gradient-to-r from-blue-500 to-indigo-600
                   hover:from-blue-600 hover:to-indigo-700
                   text-white font-semibold shadow-md transition">



        🖨️ Print Invoice



    </button>







    <a href="{{ route('sales.pdf',$sale->id) }}"
       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
              bg-gradient-to-r from-red-500 to-rose-600
              hover:from-red-600 hover:to-rose-700
              text-white font-semibold shadow-md transition">



        📄 Download PDF



    </a>




</div>





</div>





</div>





</div>



@endsection