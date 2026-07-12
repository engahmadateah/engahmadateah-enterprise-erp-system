@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="space-y-8">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">

        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>

        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    Products Inventory
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Manage products, stock levels, prices, and inventory records from one modern dashboard.
                </p>

            </div>


            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                      bg-white text-indigo-700 font-semibold
                      shadow-xl hover:scale-105 transition">

                <span class="text-xl">📦</span>

                Add Product

            </a>


        </div>

    </div>


    {{-- Statistics --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">


        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Products
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">
                        {{ $products->count() }}
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
                        Total Quantity
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-green-600">
                        {{ $products->sum('quantity') }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                    📊
                </div>

            </div>

        </div>



        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Low Stock
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-red-600">
                        {{ $products->filter(fn($p) => $p->quantity <= $p->low_stock)->count() }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">
                    ⚠️
                </div>

            </div>

        </div>



        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Inventory Value
                    </p>

                    <h2 class="text-4xl font-bold mt-3 text-purple-600">
                        {{ number_format($products->sum(fn($p)=>$p->purchase_price * $p->quantity),2) }}
                    </h2>

                </div>


                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">
                    💰
                </div>

            </div>

        </div>


    </div>
    {{-- Products Table --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">


        <div class="px-6 py-5 border-b bg-slate-50">

            <h2 class="text-2xl font-bold text-slate-800">
                Product Records
            </h2>

            <p class="text-slate-500 mt-1">
                List of all products and current inventory status.
            </p>

        </div>


        <div class="overflow-x-auto" dir="ltr">

            <table class="min-w-full">


                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left font-semibold">
                            SKU
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Product
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Quantity
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Purchase Price
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Sale Price
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Actions
                        </th>

                    </tr>

                </thead>



                <tbody>


                    @forelse($products as $product)


                    <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">


                        <td class="px-6 py-5 font-semibold text-slate-700">

                            {{ $product->sku }}

                        </td>



                        <td class="px-6 py-5">


                            <div class="flex items-center gap-4">


                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center font-bold text-lg">


                                    📦


                                </div>


                                <div>


                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="font-bold text-slate-800 hover:text-indigo-600 transition">


                                        {{ $product->name }}


                                    </a>


                                    <div class="text-sm text-slate-500">

                                        Product Item

                                    </div>


                                </div>


                            </div>


                        </td>




                        <td class="px-6 py-5">


                            <div class="flex items-center gap-3">


                                <span class="font-semibold text-slate-700">

                                    {{ $product->quantity }}

                                </span>



                                @if($product->quantity <= $product->low_stock)


                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-red-100 text-red-700 font-semibold text-sm">

                                        ⚠️ Low ({{ $product->low_stock }})

                                    </span>


                                @else


                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-green-100 text-green-700 font-semibold text-sm">

                                        ✅ OK

                                    </span>


                                @endif


                            </div>


                        </td>




                        <td class="px-6 py-5 text-slate-700">


                            {{ number_format($product->purchase_price,2) }}


                        </td>




                        <td class="px-6 py-5 text-slate-700">


                            {{ number_format($product->sale_price,2) }}


                        </td>




                        <td class="px-6 py-5">
                        <div class="flex justify-center gap-3">


{{-- Edit --}}

<a href="{{ route('products.edit',$product->id) }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
          bg-gradient-to-r from-amber-500 to-orange-500
          hover:from-amber-600 hover:to-orange-600
          text-white font-semibold shadow-md transition">


    ✏️ Edit


</a>



{{-- Delete --}}

<form method="POST"
      action="{{ route('products.destroy',$product->id) }}"
      onsubmit="return confirm('Are you sure?')">


    @csrf
    @method('DELETE')


    <button type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                   bg-gradient-to-r from-red-500 to-rose-600
                   hover:from-red-600 hover:to-rose-700
                   text-white font-semibold shadow-md transition">


        🗑 Delete


    </button>


</form>


</div>


</td>


</tr>



@empty



<tr>


<td colspan="6" class="px-6 py-16 text-center">


<div class="flex flex-col items-center">


<div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">

    📦

</div>



<h3 class="text-xl font-bold text-slate-700">

    No Products Found

</h3>



<p class="text-slate-500 mt-2">

    There are currently no products available in inventory.

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