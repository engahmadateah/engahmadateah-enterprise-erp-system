@extends('layouts.app')

@section('title','Add Customer')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Customer
        </h1>

        <p class="text-indigo-100 mt-2">
            Create a new customer and manage customer information.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('customers.store') }}"
            class="space-y-6">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Customer Name --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Customer Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: John Smith"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Phone --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Phone
                    </label>


                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Example: +1 555 123 456"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Email --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>


                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Example: customer@example.com"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Address --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Address
                    </label>


                    <textarea
                        name="address"
                        rows="4"
                        placeholder="Example: 123 Main Street, City"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">{{ old('address') }}</textarea>


                </div>


            </div>



            {{-- Active --}}
            <div>

                <label class="flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                        class="rounded text-indigo-600 focus:ring-indigo-500">


                    <span class="text-sm font-semibold text-slate-700">
                        Active Customer
                    </span>

                </label>

            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('customers.index') }}"
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

                    Save Customer

                </button>


            </div>


        </form>


    </div>


</div>


@endsection