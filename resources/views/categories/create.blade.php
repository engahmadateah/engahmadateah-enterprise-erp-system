@extends('layouts.app')

@section('title','Add Category')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Add Category
        </h1>

        <p class="text-indigo-100 mt-2">
            Create a new product category for your inventory.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('categories.store') }}"
            class="space-y-6">

            @csrf



            {{-- Category Name --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Category Name
                </label>


                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Example: Electronics"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('categories.index') }}"
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

                    Save Category

                </button>


            </div>


        </form>


    </div>


</div>


@endsection