@extends('layouts.app')

@section('title','Edit Sale')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <div class="bg-white rounded shadow p-6">

        <h2 class="text-xl font-bold mb-6">
            Edit Sale
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <form method="POST" action="{{ route('sales.update', $sale->id) }}">
            @csrf
            @method('PUT')

            {{-- Customer --}}
            <div class="mb-4">
                <label class="block mb-2">Customer</label>

                <select name="customer_id" class="w-full border rounded p-3" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Product --}}
            <div class="mb-4">
                <label class="block mb-2">Product</label>

                <select name="product_id" class="w-full border rounded p-3" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stock: {{ $product->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Warehouse --}}
            <div class="mb-4">
                <label class="block mb-2">Warehouse</label>

                <select name="warehouse_id" class="w-full border rounded p-3" required>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}"
                            {{ $sale->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Quantity --}}
            <div class="mb-4">
                <label class="block mb-2">Quantity</label>

                <input type="number"
                       name="quantity"
                       min="1"
                       value="{{ $sale->quantity }}"
                       class="w-full border rounded p-3"
                       required>
            </div>

            {{-- Unit Price --}}
            <div class="mb-4">
                <label class="block mb-2">Unit Price</label>

                <input type="number"
                       step="0.01"
                       name="unit_price"
                       value="{{ $sale->unit_price }}"
                       class="w-full border rounded p-3"
                       required>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded">

                Update Sale

            </button>

        </form>

    </div>

</div>

@endsection