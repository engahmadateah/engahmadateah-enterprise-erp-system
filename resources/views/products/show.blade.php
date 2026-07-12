@extends('layouts.app')

@section('title','Product Details')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-700 rounded-3xl p-8 shadow-xl">


        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">


            <div>

                <h1 class="text-4xl font-bold text-white">
                    {{ $product->name }}
                </h1>


                <p class="text-indigo-100 mt-2">
                    View product information and manage stock movements.
                </p>

            </div>



            <a href="{{ route('products.index') }}"
               class="px-6 py-3 rounded-xl bg-white/20 text-white
                      hover:bg-white/30 transition backdrop-blur">

                ← Back

            </a>


        </div>


    </div>





    {{-- Product Information --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <h2 class="text-xl font-bold text-slate-800 mb-6">
            Product Information
        </h2>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



            <div>

                <p class="text-sm text-slate-500">
                    SKU
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $product->sku }}
                </p>

            </div>




            <div>

                <p class="text-sm text-slate-500">
                    Category
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $product->category->name ?? '-' }}
                </p>

            </div>




            <div>

                <p class="text-sm text-slate-500">
                    Warehouse
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $product->warehouse->name ?? '-' }}
                </p>

            </div>




            <div>

                <p class="text-sm text-slate-500">
                    Current Quantity
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $product->quantity }}
                </p>

            </div>




            <div>

                <p class="text-sm text-slate-500">
                    Low Stock Level
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $product->low_stock }}
                </p>

            </div>



        </div>




        @if($product->quantity <= $product->low_stock)

            <div class="mt-6 rounded-xl bg-red-50 border border-red-200 p-4">

                <span class="font-bold text-red-600">
                    ⚠ LOW STOCK ALERT
                </span>

            </div>

        @endif



    </div>





    {{-- Stock Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



        {{-- Stock IN --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


            <h2 class="text-xl font-bold text-green-700 mb-2">
                Add Stock
            </h2>


            <p class="text-sm text-slate-500 mb-6">
                Increase available product quantity.
            </p>



            <form method="POST"
                  action="{{ route('products.addStock',$product->id) }}"
                  class="flex gap-3">


                @csrf


                <input
                    type="number"
                    name="quantity"
                    placeholder="Example: 50"
                    class="flex-1 rounded-xl border border-slate-300 px-4 py-3
                           focus:ring-4 focus:ring-green-100
                           focus:border-green-500 outline-none">


                <button
                    class="px-6 py-3 rounded-xl
                           bg-gradient-to-r from-green-600 to-emerald-600
                           hover:from-green-700 hover:to-emerald-700
                           text-white font-semibold shadow">

                    Add

                </button>


            </form>


        </div>





        {{-- Stock OUT --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


            <h2 class="text-xl font-bold text-red-700 mb-2">
                Remove Stock
            </h2>


            <p class="text-sm text-slate-500 mb-6">
                Decrease available product quantity.
            </p>



            <form method="POST"
                  action="{{ route('products.sellStock',$product->id) }}"
                  class="flex gap-3">


                @csrf


                <input
                    type="number"
                    name="quantity"
                    placeholder="Example: 10"
                    class="flex-1 rounded-xl border border-slate-300 px-4 py-3
                           focus:ring-4 focus:ring-red-100
                           focus:border-red-500 outline-none">


                <button
                    class="px-6 py-3 rounded-xl
                           bg-gradient-to-r from-red-600 to-rose-600
                           hover:from-red-700 to-rose-700
                           text-white font-semibold shadow">

                    Remove

                </button>


            </form>


        </div>



    </div>



</div>


@endsection