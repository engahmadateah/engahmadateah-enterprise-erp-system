@extends('layouts.app')

@section('title','Journal Entries')

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

                Journal Entries

            </h1>


            <p class="text-indigo-100 mt-3 text-lg">

                View and manage all accounting journal transactions.

            </p>


        </div>


        @can('journal.create')

        <a href="#"
           class="inline-flex items-center gap-3 px-7 py-4 rounded-2xl
                  bg-white text-indigo-700 font-semibold
                  shadow-xl hover:scale-105 transition">


            ➕ Add Entry


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

Total Entries

</p>


<h2 class="text-4xl font-bold mt-3 text-slate-800">

{{ $entries->count() }}

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

Entries Today

</p>


<h2 class="text-4xl font-bold mt-3 text-green-600">

{{ $entries->where('entry_date', now()->format('Y-m-d'))->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

📅

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Unique Users

</p>


<h2 class="text-4xl font-bold mt-3 text-blue-600">

{{ $entries->pluck('user_id')->unique()->count() }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

👤

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Latest Entry

</p>


<h2 class="text-xl font-bold mt-3 text-purple-600">

{{ optional($entries->sortByDesc('entry_date')->first())->entry_number ?? 'N/A' }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">

📊

</div>


</div>


</div>



</div>






{{-- Journal Entries Table --}}


<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">


        <h2 class="text-2xl font-bold text-slate-800">

            Journal Entries List

        </h2>


        <p class="text-slate-500 mt-1">

            Complete list of accounting journal transactions.

        </p>


    </div>





    <div class="overflow-x-auto" dir="ltr">


        <table class="min-w-full">


            <thead class="bg-slate-100">


                <tr>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Entry No

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Date

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Description

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        User

                    </th>



                   


                </tr>


            </thead>



            <tbody>
            @forelse($entries as $entry)


<tr class="border-b border-slate-100 hover:bg-indigo-50 transition">



    <td class="px-6 py-5">


        <span class="font-bold text-indigo-600">


            {{ $entry->entry_number }}


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


                    {{ $entry->entry_date }}


                </div>



                <div class="text-sm text-slate-500">


                    Entry Date


                </div>



            </div>


        </div>


    </td>






    <td class="px-6 py-5">


        <div class="max-w-md">


            <div class="font-semibold text-slate-800">


                {{ $entry->description }}


            </div>


            <div class="text-sm text-slate-500 mt-1">


                Journal Transaction


            </div>


        </div>


    </td>






    <td class="px-6 py-5">


        <div class="flex items-center gap-3">


            <div class="w-10 h-10 rounded-xl 
                        bg-blue-100 text-blue-700
                        flex items-center justify-center
                        font-bold">


                👤


            </div>



            <div>


                <div class="font-semibold text-slate-800">


                    {{ $entry->user?->name ?? 'System' }}


                </div>


                <div class="text-sm text-slate-500">


                    Created By


                </div>


            </div>


        </div>


    </td>






    <td class="px-6 py-5">


        <div class="flex justify-center gap-3">


            


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


                No Journal Entries Found


            </h3>



            <p class="text-slate-500 mt-2">


                There are currently no accounting journal entries available.


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