@extends('layouts.app')

@section('title','Edit Product')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Product
        </h1>

        <p class="text-orange-100 mt-2">
            Update product information, pricing, stock, and status.
        </p>

    </div>



    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('products.update',$product->id) }}"
            class="space-y-6">


            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Category --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Category
                    </label>


                    <select
                        name="category_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach


                    </select>


                </div>



                {{-- Warehouse --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Warehouse
                    </label>


                    <select
                        name="warehouse_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                        @foreach($warehouses as $warehouse)

                            <option value="{{ $warehouse->id }}"
                                {{ $product->warehouse_id == $warehouse->id ? 'selected' : '' }}>

                                {{ $warehouse->name }}

                            </option>

                        @endforeach


                    </select>


                </div>



                {{-- Product Name --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Product Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$product->name) }}"
                        placeholder="Example: Laptop"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- SKU --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        SKU
                    </label>


                    <input
                        type="text"
                        name="sku"
                        value="{{ old('sku',$product->sku) }}"
                        placeholder="Example: LAP-001"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Quantity --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Quantity
                    </label>


                    <input
                        type="number"
                        name="quantity"
                        value="{{ old('quantity',$product->quantity) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Purchase Price --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Purchase Price
                    </label>


                    <input
                        type="number"
                        step="0.01"
                        name="purchase_price"
                        value="{{ old('purchase_price',$product->purchase_price) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Sale Price --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Sale Price
                    </label>


                    <input
                        type="number"
                        step="0.01"
                        name="sale_price"
                        value="{{ old('sale_price',$product->sale_price) }}"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Status --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Product Status
                    </label>


                    <label class="inline-flex items-center gap-3 cursor-pointer mt-2">


                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $product->is_active ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-green-600 focus:ring-green-500">


                        <span class="text-slate-700 font-medium">
                            Active Product
                        </span>


                    </label>


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Product ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $product->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('products.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 transition">

                        Cancel

                    </a>



                    <button
                        type="submit"
                        class="px-8 py-3 rounded-xl
                               bg-gradient-to-r from-orange-500 to-red-500
                               hover:from-orange-600 hover:to-red-600
                               text-white font-semibold shadow-lg transition">

                        Update Product

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>


@endsection