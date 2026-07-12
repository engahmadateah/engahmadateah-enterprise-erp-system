@extends('layouts.app')

@section('title','Add Supplier')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Supplier
        </h1>

        <p class="text-indigo-100 mt-2">
            Add a new supplier and manage supplier information.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('suppliers.store') }}"
            class="space-y-6">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- Supplier Name --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Supplier Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: ABC Trading Company"
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
                        placeholder="Example: supplier@example.com"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Address --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Address
                    </label>


                    <input
                        type="text"
                        name="address"
                        value="{{ old('address') }}"
                        placeholder="Example: 123 Main Street"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('suppliers.index') }}"
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

                    Save Supplier

                </button>


            </div>


        </form>


    </div>


</div>


@endsection