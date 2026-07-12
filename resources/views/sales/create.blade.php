@extends('layouts.app')

@section('title','Add Sale')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create Sale
        </h1>

        <p class="text-indigo-100 mt-2">
            Create a new sale and manage product transactions.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        @if ($errors->any())

            <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-xl mb-6">

                <ul class="space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        <form
            method="POST"
            action="{{ route('sales.store') }}"
            class="space-y-6">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Customer --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Customer
                    </label>


                    <select
                        name="customer_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                        <option value="">
                            Select customer
                        </option>


                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>

                                {{ $customer->name }}

                            </option>

                        @endforeach


                    </select>

                </div>



                {{-- Product --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Product
                    </label>


                    <select
                        name="product_id"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                        <option value="">
                            Select product
                        </option>


                        @foreach($products as $product)

                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                {{ $product->name }}
                                (Stock: {{ $product->quantity }})

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

                            <option
                                value="{{ $warehouse->id }}"
                                {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>

                                {{ $warehouse->name }}

                            </option>

                        @endforeach


                    </select>

                </div>
                {{-- Quantity --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Quantity
                    </label>


                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        value="{{ old('quantity') }}"
                        placeholder="Example: 10"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Unit Price --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Unit Price
                    </label>


                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="unit_price"
                        value="{{ old('unit_price') }}"
                        placeholder="Example: 50.00"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('sales.index') }}"
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

                    Save Sale

                </button>


            </div>


        </form>


    </div>


</div>


@endsection