@extends('layouts.app')

@section('title','Create IT Ticket')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">


    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-700 rounded-3xl p-8 shadow-xl">

        <h1 class="text-4xl font-bold text-white">
            Create IT Ticket
        </h1>

        <p class="text-indigo-100 mt-2">
            Submit a technical issue and provide details for support.
        </p>

    </div>



    {{-- Form Card --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">


        <form
            method="POST"
            action="{{ route('tickets.store') }}"
            enctype="multipart/form-data"
            class="space-y-6">

            @csrf



            {{-- Title --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Issue Title
                </label>


                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Example: Printer is not working"
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


            </div>



            {{-- Description --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Issue Description
                </label>


                <textarea
                    name="description"
                    rows="6"
                    placeholder="Example: Explain the problem and when it started..."
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">{{ old('description') }}</textarea>


            </div>



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                {{-- TeamViewer ID --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        TeamViewer ID
                    </label>


                    <input
                        type="text"
                        name="teamviewer_id"
                        value="{{ old('teamviewer_id') }}"
                        placeholder="Example: 123 456 789"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>



                {{-- IP Address --}}
                <div>

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        IP Address
                    </label>


                    <input
                        type="text"
                        name="ip_address"
                        value="{{ old('ip_address') }}"
                        placeholder="Example: 192.168.1.100"
                        class="w-full rounded-xl border border-slate-300 px-5 py-3
                               focus:ring-4 focus:ring-indigo-100
                               focus:border-indigo-500 outline-none">


                </div>


            </div>



            {{-- Attachments --}}
            <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Screenshots / Attachments
                </label>


                <input
                    type="file"
                    name="attachments[]"
                    multiple
                    class="w-full rounded-xl border border-slate-300 px-5 py-3
                           focus:ring-4 focus:ring-indigo-100
                           focus:border-indigo-500 outline-none">


                <p class="text-xs text-slate-400 mt-2">
                    You can upload multiple screenshots.
                </p>


            </div>



            {{-- Buttons --}}
            <div class="flex justify-end gap-4 pt-4">


                <a href="{{ route('tickets.index') }}"
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

                    Submit Ticket

                </button>


            </div>


        </form>


    </div>


</div>


@endsection