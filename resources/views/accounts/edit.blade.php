@extends('layouts.app')

@section('title','Edit Account')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit Account
        </h1>

        <p class="text-orange-100 mt-2">
            Update account information and financial settings.
        </p>

    </div>



    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('accounts.update',$account->id) }}"
            class="space-y-6">

            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Account Code --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Account Code
                    </label>


                    <input
                        type="text"
                        name="code"
                        value="{{ old('code',$account->code) }}"
                        placeholder="Example: 1000"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Account Name --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Account Name
                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$account->name) }}"
                        placeholder="Example: Cash Account"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                </div>



                {{-- Account Type --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Account Type
                    </label>


                    <select
                        name="type"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-orange-100
                               focus:border-orange-500 outline-none transition">


                        <option value="asset"
                            {{ $account->type=='asset' ? 'selected' : '' }}>
                            Asset
                        </option>


                        <option value="liability"
                            {{ $account->type=='liability' ? 'selected' : '' }}>
                            Liability
                        </option>


                        <option value="equity"
                            {{ $account->type=='equity' ? 'selected' : '' }}>
                            Equity
                        </option>


                        <option value="revenue"
                            {{ $account->type=='revenue' ? 'selected' : '' }}>
                            Revenue
                        </option>


                        <option value="expense"
                            {{ $account->type=='expense' ? 'selected' : '' }}>
                            Expense
                        </option>


                    </select>


                </div>



                {{-- Status --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Account Status
                    </label>


                    <label class="inline-flex items-center gap-3 cursor-pointer">


                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $account->is_active ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-green-600 focus:ring-green-500">


                        <span class="text-slate-700 font-medium">
                            Active Account
                        </span>


                    </label>


                </div>


            </div>



            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Account ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $account->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('accounts.index') }}"
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

                        Update Account

                    </button>


                </div>


            </div>


        </form>


    </div>


</div>


@endsection