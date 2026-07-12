@extends('layouts.app')

@section('title','IT Tickets Management')

@section('content')

<div class="space-y-8">


    {{-- Hero --}}

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">


        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>




        <div class="relative">



            <h1 class="text-4xl lg:text-5xl font-bold text-white">

                IT Tickets Management

            </h1>





            <p class="text-indigo-100 mt-3 text-lg">

                Manage technical support requests, update ticket status, and monitor IT operations.

            </p>




        </div>



    </div>






    {{-- Statistics --}}


    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">





        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Total Tickets

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-indigo-600">

                        {{ $tickets->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">

                    🎫

                </div>


            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Pending

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-yellow-600">

                        {{ $tickets->where('status','pending')->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-3xl">

                    ⏳

                </div>


            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Processing

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-blue-600">

                        {{ $tickets->where('status','processing')->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

                    🛠️

                </div>


            </div>


        </div>






        <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-6">


            <div class="flex justify-between items-center">


                <div>


                    <p class="text-slate-500 text-sm">

                        Completed

                    </p>




                    <h2 class="text-4xl font-bold mt-3 text-green-600">

                        {{ $tickets->where('status','completed')->count() }}

                    </h2>


                </div>



                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

                    ✅

                </div>


            </div>


        </div>





    </div>
    {{-- Tickets Table --}}

<div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">



    <div class="px-6 py-5 border-b bg-slate-50">



        <h2 class="text-2xl font-bold text-slate-800">

            All IT Tickets

        </h2>




        <p class="text-slate-500 mt-1">

            Review requests and update their progress.

        </p>



    </div>






    <div class="overflow-x-auto" dir="ltr">



        <table class="min-w-full">





            <thead class="bg-slate-100">



                <tr>



                    <th class="px-6 py-4 text-left font-semibold">
                        Ticket
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        User
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Title
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        TeamViewer ID
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        IP Address
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Attachments
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Status
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Created
                    </th>



                    <th class="px-6 py-4 text-center font-semibold">
                        Action
                    </th>



                </tr>



            </thead>






            <tbody>




                @forelse($tickets as $ticket)





                <tr class="border-b border-slate-100 hover:bg-indigo-50 transition">





                    <td class="px-6 py-5">


                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-100 text-indigo-700 font-bold">


                            🎫 {{ $ticket->ticket_number }}


                        </span>



                    </td>






                    <td class="px-6 py-5">


                        <div class="font-bold text-slate-800">


                            {{ $ticket->user->name ?? 'N/A' }}


                        </div>



                    </td>






                    <td class="px-6 py-5 font-semibold text-slate-700">


                        {{ $ticket->title }}



                    </td>






                    <td class="px-6 py-5">


                        {{ $ticket->teamviewer_id ?? '-' }}



                    </td>






                    <td class="px-6 py-5">


                        {{ $ticket->ip_address ?? '-' }}



                    </td>






                    <td class="px-6 py-5">



                        @if(!empty($ticket->attachments))



                            <div class="flex flex-wrap gap-2">



                                @foreach($ticket->attachments as $file)



                                    <a href="{{ asset('storage/'.$file) }}"
                                       target="_blank">



                                        <img src="{{ asset('storage/'.$file) }}"
                                             class="w-12 h-12 rounded-xl object-cover border shadow-sm hover:scale-105 transition">



                                    </a>



                                @endforeach



                            </div>



                        @else



                            <span class="text-slate-400">

                                No files

                            </span>



                        @endif



                    </td>
                    <td class="px-6 py-5">


@if($ticket->status == 'pending')


    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-yellow-100 text-yellow-700 font-semibold">


        ⏳ Pending


    </span>




@elseif($ticket->status == 'processing')



    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-semibold">


        🛠️ Processing


    </span>





@elseif($ticket->status == 'completed')



    <span class="inline-flex items-center px-4 py-2 rounded-xl bg-green-100 text-green-700 font-semibold">


        ✅ Completed


    </span>



@endif



</td>







<td class="px-6 py-5 text-slate-700">


{{ $ticket->created_at->format('Y-m-d H:i') }}



</td>






<td class="px-6 py-5">



<form method="POST"
      action="{{ route('tickets.status',$ticket) }}"
      class="flex items-center justify-center gap-3">



    @csrf

    @method('PUT')





    <select name="status"
            class="px-4 py-2 rounded-xl border border-slate-200
                   focus:ring-2 focus:ring-indigo-500">



        <option value="pending"
            {{ $ticket->status == 'pending' ? 'selected' : '' }}>

            Pending

        </option>



        <option value="processing"
            {{ $ticket->status == 'processing' ? 'selected' : '' }}>

            Processing

        </option>



        <option value="completed"
            {{ $ticket->status == 'completed' ? 'selected' : '' }}>

            Completed

        </option>



    </select>






    <button type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                   bg-gradient-to-r from-green-500 to-emerald-600
                   hover:from-green-600 hover:to-emerald-700
                   text-white font-semibold shadow-md transition">



        💾 Save



    </button>





</form>




</td>





</tr>





@empty





<tr>



<td colspan="9" class="px-6 py-16 text-center">





<div class="flex flex-col items-center">





    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-5xl mb-4">


        🎫


    </div>







    <h3 class="text-xl font-bold text-slate-700">


        No Tickets Found


    </h3>







    <p class="text-slate-500 mt-2">


        There are currently no IT support tickets available.


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