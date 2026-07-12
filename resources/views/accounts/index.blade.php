@extends('layouts.app')

@section('title','Accounts')

@section('content')

<div class="space-y-8">


{{-- Hero --}}

<div class="relative overflow-hidden rounded-3xl 
            bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700
            p-8 shadow-2xl">


    <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>



    <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">


        <div>


            <h1 class="text-4xl lg:text-5xl font-bold text-white">

                Chart Of Accounts

            </h1>


            <p class="text-indigo-100 mt-3 text-lg">

                Manage financial accounts and accounting structure.

            </p>


        </div>


        @can('accounts.create')

        <a href="{{ route('accounts.create') }}"
           class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                  bg-white text-indigo-700 font-semibold
                  shadow-xl hover:scale-105 transition">


            ➕ Add Account


        </a>

        @endcan

    </div>


</div>




{{-- Statistics --}}


<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">



<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Total Accounts

</p>


<h2 class="text-4xl font-bold mt-3 text-slate-800">

{{ $accounts->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

📒

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Active Accounts

</p>


<h2 class="text-4xl font-bold mt-3 text-green-600">

{{ $accounts->where('is_active',1)->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

✅

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Inactive Accounts

</p>


<h2 class="text-4xl font-bold mt-3 text-red-600">

{{ $accounts->where('is_active',0)->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-3xl">

⛔

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Account Types

</p>


<h2 class="text-4xl font-bold mt-3 text-blue-600">

{{ $accounts->pluck('type')->unique()->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

📊

</div>


</div>


</div>



</div>
{{-- Accounts Table --}}


<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">


    <div class="px-6 py-5 border-b bg-slate-50">


        <h2 class="text-2xl font-bold text-slate-800">

            Accounts List

        </h2>


        <p class="text-slate-500 mt-1">

            Complete list of financial accounts.

        </p>


    </div>




    <div class="overflow-x-auto" dir="ltr">


        <table class="min-w-full">


            <thead class="bg-slate-100">


                <tr>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Code

                    </th>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Account Name

                    </th>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Type

                    </th>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Status

                    </th>


                    <th class="px-6 py-4 text-center font-semibold text-slate-700">

                        Actions

                    </th>


                </tr>


            </thead>





            <tbody>



            @forelse($accounts as $account)



            <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">



                <td class="px-6 py-5">


                    <span class="font-bold text-indigo-600">


                        {{ $account->code }}


                    </span>


                </td>





                <td class="px-6 py-5">


                    <div class="flex items-center gap-3">


                        <div class="w-12 h-12 rounded-2xl 
                                    bg-gradient-to-br from-indigo-500 to-violet-600
                                    text-white flex items-center justify-center
                                    font-bold text-lg">


                            📒


                        </div>



                        <div>


                            <div class="font-bold text-slate-800">


                                {{ $account->name }}


                            </div>



                            <div class="text-sm text-slate-500">


                                Account ID: {{ $account->id }}


                            </div>



                        </div>



                    </div>



                </td>






                <td class="px-6 py-5">


                    @php

                        $typeColors = [

                            'asset'=>'bg-blue-100 text-blue-700',

                            'liability'=>'bg-red-100 text-red-700',

                            'income'=>'bg-green-100 text-green-700',

                            'expense'=>'bg-orange-100 text-orange-700',

                            'equity'=>'bg-purple-100 text-purple-700',

                        ];

                        $color = $typeColors[$account->type] 
                                 ?? 'bg-slate-100 text-slate-700';

                    @endphp




                    <span class="px-4 py-2 rounded-xl font-semibold {{ $color }}">


                        {{ ucfirst($account->type) }}


                    </span>


                </td>






                <td class="px-6 py-5">


                    @if($account->is_active)


                        <span class="inline-flex items-center gap-2
                                     px-4 py-2 rounded-xl
                                     bg-green-100 text-green-700 font-semibold">


                            ✅ Active


                        </span>


                    @else


                        <span class="inline-flex items-center gap-2
                                     px-4 py-2 rounded-xl
                                     bg-red-100 text-red-700 font-semibold">


                            ❌ Inactive


                        </span>


                    @endif



                </td>






                <td class="px-6 py-5">


                    <div class="flex justify-center gap-3">


                        @can('accounts.edit')
                        <a href="{{ route('accounts.edit',$account->id) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                                  bg-gradient-to-r from-amber-500 to-orange-500
                                  hover:from-amber-600 hover:to-orange-600
                                  text-white font-semibold shadow-md transition">


                            ✏️ Edit


                        </a>

                            @endcan




                        <form method="POST"
                              action="{{ route('accounts.destroy',$account->id) }}"
                              onsubmit="return confirm('Delete Account?')">


                            @csrf

                            @method('DELETE')

                            @can('accounts.delete')

                            <button
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                                       bg-gradient-to-r from-red-500 to-rose-600
                                       hover:from-red-600 hover:to-rose-700
                                       text-white font-semibold shadow-md transition">


                                🗑 Delete


                            </button>
                                @endcan


                        </form>




                    </div>


                </td>




            </tr>




            @empty



            <tr>


                <td colspan="5" class="px-6 py-16 text-center">


                    <div class="flex flex-col items-center">



                        <div class="w-24 h-24 rounded-full bg-slate-100 
                                    flex items-center justify-center text-5xl mb-4">


                            📒


                        </div>



                        <h3 class="text-xl font-bold text-slate-700">


                            No Accounts Found


                        </h3>



                        <p class="text-slate-500 mt-2">


                            There are currently no financial accounts available.


                        </p>



                    </div>



                </td>


            </tr>



            @endforelse




            </tbody>


        </table>



    </div>



</div>



</div>


@endsection