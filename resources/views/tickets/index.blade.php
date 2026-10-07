@extends('layouts.app')

@section('title','My IT Tickets')

@section('content')

<div class="space-y-8">


    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 p-8 shadow-2xl">


        <div class="absolute -top-12 -right-12 w-52 h-52 bg-white/10 rounded-full"></div>

        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full"></div>




        <div class="relative flex flex-col lg:flex-row justify-between items-center gap-6">



            <div>



                <h1 class="text-4xl lg:text-5xl font-bold text-white">

                    My IT Tickets

                </h1>




                <p class="text-indigo-100 mt-3 text-lg">

                    Track support requests, technical issues, attachments, and ticket progress from one dashboard.

                </p>



            </div>






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

            Ticket Records

        </h2>




        <p class="text-slate-500 mt-1">

            List of your IT support requests and their current status.

        </p>



    </div>






    <div class="overflow-x-auto" dir="ltr">



        <table class="min-w-full">





            <thead class="bg-slate-100">



                <tr>



                    <th class="px-6 py-4 text-left font-semibold">
                        Ticket No
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        User
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        Title
                    </th>



                    <th class="px-6 py-4 text-left font-semibold">
                        TeamViewer
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
                        Date
                    </th>



                    <th class="px-6 py-4 text-center font-semibold">
                        Actions
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






                    <td class="px-6 py-5">


                        <div class="font-semibold text-slate-700">


                            {{ $ticket->title }}


                        </div>



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



                                @foreach($ticket->attachments as $fileIndex => $file)



                                    <a href="{{ route('tickets.attachment', [$ticket, $fileIndex]) }}"
                                       target="_blank"
                                       class="group">



                                        <img src="{{ route('tickets.attachment', [$ticket, $fileIndex]) }}"
                                             class="w-12 h-12 rounded-xl object-cover border shadow-sm group-hover:scale-105 transition">



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


<div class="flex justify-center gap-3">





    {{-- Edit --}}

    <a href="{{ route('tickets.edit', $ticket) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
              bg-gradient-to-r from-amber-500 to-orange-500
              hover:from-amber-600 hover:to-orange-600
              text-white font-semibold shadow-md transition">


        ✏️ Edit


    </a>







    {{-- Delete --}}

    <form method="POST"
          action="{{ route('tickets.destroy', $ticket) }}"
          onsubmit="return confirm('Are you sure?')">



        @csrf

        @method('DELETE')




        <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                       bg-gradient-to-r from-red-500 to-rose-600
                       hover:from-red-600 hover:to-rose-700
                       text-white font-semibold shadow-md transition">


            🗑 Delete


        </button>



    </form>




</div>



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