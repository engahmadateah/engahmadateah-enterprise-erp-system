@extends('layouts.app')

@section('title','Create Account')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create Account
        </h1>

        <p class="text-indigo-100 mt-2">
            Create a new accounting account and manage financial records.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('accounts.store') }}"
            class="space-y-6">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- Account Code --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Account Code
                    </label>


                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Example: 1000"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Account Name --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Account Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Example: Cash Account"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- Account Type --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Account Type
                    </label>


                    <select
                        name="type"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                        <option value="">
                            Select account type
                        </option>


                        <option value="asset">
                            Asset
                        </option>


                        <option value="liability">
                            Liability
                        </option>


                        <option value="equity">
                            Equity
                        </option>


                        <option value="revenue">
                            Revenue
                        </option>


                        <option value="expense">
                            Expense
                        </option>


                    </select>


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
                        Active Account
                    </span>


                </label>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('accounts.index') }}"
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

                    Save Account

                </button>


            </div>


        </form>


    </div>


</div>


@endsection