@extends('layouts.app')

@section('title','Edit Warehouse')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Warehouse
        </h1>

        <p class="text-emerald-100 mt-2">
            Update warehouse information and storage location details.
        </p>

    </div>




    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form method="POST"
              action="{{ route('warehouses.update', $warehouse->id) }}"
              class="space-y-6">


            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Warehouse Name --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Warehouse Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$warehouse->name) }}"
                        placeholder="Example: Main Warehouse"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-emerald-100
                               focus:border-emerald-500 outline-none transition">


                </div>





                {{-- Location --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Location
                    </label>


                    <input
                        type="text"
                        name="location"
                        value="{{ old('location',$warehouse->location) }}"
                        placeholder="Example: Industrial Area"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-emerald-100
                               focus:border-emerald-500 outline-none transition">


                </div>



            </div>





            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">



                <div class="text-sm text-slate-400">

                    Warehouse ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $warehouse->id }}
                    </span>

                </div>




                <div class="flex justify-end gap-4">


                    <a href="{{ route('warehouses.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 transition">

                        Cancel

                    </a>





                    <button
                        type="submit"
                        class="px-8 py-3 rounded-xl
                               bg-gradient-to-r from-emerald-600 to-teal-600
                               hover:from-emerald-700 hover:to-teal-700
                               text-white font-semibold shadow-lg transition">

                        Update Warehouse

                    </button>


                </div>


            </div>




        </form>


    </div>


</div>


@endsection