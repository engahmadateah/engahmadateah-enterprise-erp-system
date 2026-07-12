@extends('layouts.app')

@section('title','Edit Customer')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Customer
        </h1>

        <p class="text-orange-100 mt-2">
            Update customer information and account status.
        </p>

    </div>



    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('customers.update',$customer->id) }}"
            class="space-y-6">


            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Name --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Customer Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$customer->name) }}"
                        placeholder="Example: John Smith"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Phone --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Phone
                    </label>


                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone',$customer->phone) }}"
                        placeholder="Example: +1 555 123456"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Email --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Email
                    </label>


                    <input
                        type="email"
                        name="email"
                        value="{{ old('email',$customer->email) }}"
                        placeholder="Example: customer@email.com"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Status --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Customer Status
                    </label>


                    <label class="inline-flex items-center gap-3 cursor-pointer mt-2">


                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $customer->is_active ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-green-600 focus:ring-green-500">


                        <span class="text-slate-700 font-medium">
                            Active Customer
                        </span>


                    </label>


                </div>


            </div>



            {{-- Address --}}
            <div>

                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Address
                </label>


                <textarea
                    name="address"
                    rows="4"
                    placeholder="Example: New York, USA"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-orange-100
                           focus:border-orange-500 outline-none transition">{{ old('address',$customer->address) }}</textarea>


            </div>



            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Customer ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $customer->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('customers.index') }}"
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

                        Update Customer

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>


@endsection