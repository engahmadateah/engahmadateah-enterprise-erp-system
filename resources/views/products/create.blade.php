@extends('layouts.app')

@section('title','Add Product')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Product
        </h1>

        <p class="text-indigo-100 mt-2">
            Add a new product and manage inventory information.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('products.store') }}"
            class="space-y-6">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- Category --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Category
                    </label>


                    <select
                        name="category_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                        <option value="">
                            Select category
                        </option>


                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                        @endforeach


                    </select>

                </div>



                {{-- Warehouse --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Warehouse
                    </label>


                    <select
                        name="warehouse_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                        <option value="">
                            Select warehouse
                        </option>


                        @foreach($warehouses as $warehouse)

                            <option value="{{ $warehouse->id }}">

                                {{ $warehouse->name }}

                            </option>

                        @endforeach


                    </select>

                </div>



                {{-- Product Name --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Product Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: Wireless Keyboard"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- SKU --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        SKU
                    </label>


                    <input
                        type="text"
                        name="sku"
                        value="{{ old('sku') }}"
                        placeholder="Example: PROD-001"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>
                {{-- Quantity --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Quantity
                    </label>


                    <input
                        type="number"
                        name="quantity"
                        value="{{ old('quantity') }}"
                        placeholder="Example: 100"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Purchase Price --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Purchase Price
                    </label>


                    <input
                        type="number"
                        step="0.01"
                        name="purchase_price"
                        value="{{ old('purchase_price') }}"
                        placeholder="Example: 25.00"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Sale Price --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Sale Price
                    </label>


                    <input
                        type="number"
                        step="0.01"
                        name="sale_price"
                        value="{{ old('sale_price') }}"
                        placeholder="Example: 35.00"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('products.index') }}"
                   class="px-6 py-3 rounded-xl
                          border border-slate-300
                          text-slate-700
                          hover:bg-slate-100
                          transition">

                    Cancel

                </a>


                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl
                           bg-gradient-to-r from-indigo-600 to-violet-600
                           hover:from-indigo-700 hover:to-violet-700
                           text-white font-semibold
                           shadow-lg
                           transition">

                    Save Product

                </button>


            </div>


        </form>


    </div>


</div>


@endsection