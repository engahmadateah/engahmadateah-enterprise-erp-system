@extends('layouts.app')

@section('title','Edit IT Ticket')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Edit IT Ticket
        </h1>

        <p class="text-blue-100 mt-2">
            Update issue details, remote access information, and ticket status.
        </p>

    </div>




    {{-- Form --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form method="POST"
              action="{{ route('tickets.update', $ticket) }}"
              class="space-y-6">


            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- Title --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Issue Title
                    </label>


                    <input
                        type="text"
                        name="title"
                        value="{{ old('title',$ticket->title) }}"
                        placeholder="Example: Computer not starting"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-blue-100
                               focus:border-blue-500 outline-none transition">


                </div>




                {{-- TeamViewer --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        TeamViewer ID
                    </label>


                    <input
                        type="text"
                        name="teamviewer_id"
                        value="{{ old('teamviewer_id',$ticket->teamviewer_id) }}"
                        placeholder="Example: 123 456 789"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-blue-100
                               focus:border-blue-500 outline-none transition">


                </div>




                {{-- IP --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        IP Address
                    </label>


                    <input
                        type="text"
                        name="ip_address"
                        value="{{ old('ip_address',$ticket->ip_address) }}"
                        placeholder="Example: 192.168.1.10"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-blue-100
                               focus:border-blue-500 outline-none transition">


                </div>




                {{-- Status --}}
                <div>

                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Ticket Status
                    </label>


                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-blue-100
                               focus:border-blue-500 outline-none transition">


                        <option value="pending"
                            @selected($ticket->status == 'pending')>
                            Pending
                        </option>


                        <option value="processing"
                            @selected($ticket->status == 'processing')>
                            Processing
                        </option>


                        <option value="completed"
                            @selected($ticket->status == 'completed')>
                            Completed
                        </option>


                    </select>


                </div>


            </div>





            {{-- Description --}}
            <div>


                <label class="block mb-2 text-sm font-semibold text-slate-700">
                    Description
                </label>


                <textarea
                    name="description"
                    rows="5"
                    placeholder="Describe the issue details..."
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-blue-100
                           focus:border-blue-500 outline-none transition">{{ old('description',$ticket->description) }}</textarea>


            </div>





            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t">


                <div class="text-sm text-slate-400">

                    Ticket ID:

                    <span class="font-semibold text-slate-600">
                        #{{ $ticket->id }}
                    </span>

                </div>



                <div class="flex justify-end gap-4">


                    <a href="{{ route('tickets.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300
                              text-slate-700 hover:bg-slate-100 transition">

                        Cancel

                    </a>




                    <button
                        type="submit"
                        class="px-8 py-3 rounded-xl
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700
                               text-white font-semibold shadow-lg transition">

                        Update Ticket

                    </button>


                </div>


            </div>



        </form>


    </div>


</div>


@endsection