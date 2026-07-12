@extends('layouts.app')

@section('title','Accounting')

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

                General Accounting

            </h1>


            <p class="text-indigo-100 mt-3 text-lg">

                Review accounting transactions, journal lines and financial movements.

            </p>


        </div>


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


<div class="flex justify-between">

<div>


<p class="text-slate-500 text-sm">

Total Debit Lines

</p>


<h2 class="text-4xl font-bold mt-3 text-green-600">

{{ $entries->sum(fn($entry)=>$entry->lines->where('debit','>',0)->count()) }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

💰

</div>


</div>


</div>
<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Total Credit Lines

</p>


<h2 class="text-4xl font-bold mt-3 text-red-600">

{{ $entries->sum(fn($entry)=>$entry->lines->where('credit','>',0)->count()) }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-red-100 flexّ items-center justify-center text-3xl">

📉

</div>


</div>


</div>





<div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


<div class="flex justify-between items-center">


<div>


<p class="text-slate-500 text-sm">

Account Movements

</p>


<h2 class="text-4xl font-bold mt-3 text-blue-600">

{{ $entries->sum(fn($entry)=>$entry->lines->count()) }}

</h2>


</div>


<div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

📊

</div>


</div>


</div>



</div>






{{-- Accounting Table --}}


<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">


        <h2 class="text-2xl font-bold text-slate-800">

            Accounting Transactions

        </h2>


        <p class="text-slate-500 mt-1">

            Complete overview of journal entries and debit / credit movements.

        </p>


    </div>





    <div class="overflow-x-auto" dir="ltr">


        <table class="min-w-full">


            <thead class="bg-slate-100">


                <tr>


                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Date

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Entry #

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Description

                    </th>



                    <th class="px-6 py-4 text-left font-semibold text-slate-700">

                        Debits / Credits

                    </th>


                </tr>


            </thead>



            <tbody>
            @forelse($entries as $entry)


<tr class="border-b border-slate-100 hover:bg-indigo-50 transition">



    <td class="px-6 py-5">


        <div class="flex items-center gap-3">


            <div class="w-12 h-12 rounded-2xl
                        bg-gradient-to-br from-indigo-500 to-violet-600
                        text-white flex items-center justify-center
                        font-bold text-lg">


                📅


            </div>



            <div>


                <div class="font-bold text-slate-800">


                    {{ $entry->entry_date }}


                </div>


                <div class="text-sm text-slate-500">

                    Transaction Date

                </div>


            </div>


        </div>


    </td>






    <td class="px-6 py-5">


        <span class="px-4 py-2 rounded-xl
                     bg-indigo-100 text-indigo-700
                     font-bold">


            #{{ $entry->entry_number }}


        </span>


    </td>






    <td class="px-6 py-5">


        <div>


            <div class="font-bold text-slate-800">


                {{ $entry->description }}


            </div>



            <div class="text-sm text-slate-500 mt-1">


                Journal Entry


            </div>


        </div>


    </td>






    <td class="px-6 py-5">


        <div class="space-y-3">


            @foreach($entry->lines as $line)


                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">


                    <div class="font-bold text-slate-800 mb-2">


                        {{ $line->account->name }}


                    </div>



                    <div class="flex flex-wrap gap-2">



                        @if($line->debit > 0)

                        <span class="px-3 py-1 rounded-xl
                                     bg-green-100 text-green-700
                                     font-semibold text-sm">


                            Debit: {{ number_format($line->debit,2) }}


                        </span>

                        @endif





                        @if($line->credit > 0)

                        <span class="px-3 py-1 rounded-xl
                                     bg-red-100 text-red-700
                                     font-semibold text-sm">


                            Credit: {{ number_format($line->credit,2) }}


                        </span>

                        @endif



                    </div>


                </div>


            @endforeach


        </div>


    </td>



</tr>





@empty



<tr>


    <td colspan="4" class="px-6 py-16 text-center">



        <div class="flex flex-col items-center">



            <div class="w-24 h-24 rounded-full bg-slate-100
                        flex items-center justify-center text-5xl mb-4">


                📊


            </div>



            <h3 class="text-xl font-bold text-slate-700">


                No Accounting Records Found


            </h3>



            <p class="text-slate-500 mt-2">


                There are currently no accounting transactions available.


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