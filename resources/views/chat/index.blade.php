@extends('layouts.app')

@section('content')


<div class="flex h-screen bg-slate-100 overflow-hidden">



    {{-- Chat Sidebar --}}


    <div class="w-96 bg-gradient-to-b from-slate-950 via-slate-900 to-indigo-950
                text-white flex flex-col shadow-2xl">





        {{-- Header --}}


        <div class="p-6 border-b border-white/10">


            <div class="flex justify-between items-center">


                <div>


                    <h2 class="text-2xl font-black">

                        Conversations

                    </h2>


                    <p class="text-sm text-slate-400 mt-1">

                        Your messages

                    </p>


                </div>




                <a href="{{ route('chat.users') }}"
                   class="inline-flex items-center gap-2
                          px-4 py-3 rounded-2xl
                          bg-gradient-to-r from-indigo-500 to-violet-600
                          hover:scale-105 transition
                          font-semibold shadow-lg">


                    ➕ New


                </a>



            </div>


        </div>






        {{-- Conversation List --}}


        <div class="overflow-y-auto flex-1 p-4 space-y-3">


            @forelse($conversations as $conversation)



                @php

                    $otherUser = $conversation->users
                        ->where('id','!=',auth()->id())
                        ->first();

                    $lastMessage = $conversation
                        ->messages()
                        ->latest()
                        ->first();


                    $hasUnread = $conversation
                        ->messages()
                        ->where('user_id','!=',auth()->id())
                        ->where('is_read',false)
                        ->exists();

                @endphp





                <a href="{{ route('chat.show',$conversation) }}"
                   class="block rounded-2xl
                          bg-white/5
                          hover:bg-white/10
                          border border-white/5
                          p-4 transition">



                    <div class="flex items-center gap-3">
                    {{-- Avatar --}}


<div class="w-12 h-12 rounded-2xl
            bg-gradient-to-br from-indigo-500 to-violet-600
            flex items-center justify-center
            font-bold text-xl shadow-lg">


    {{ strtoupper(substr($otherUser->name ?? 'G',0,1)) }}


</div>





<div class="flex-1 min-w-0">


    <div class="flex justify-between items-center">


        <div class="font-bold truncate">


            {{ $otherUser->name ?? 'Group Chat' }}


        </div>





        {{-- Unread Dot --}}


        @if($hasUnread)

            <span class="w-3 h-3 rounded-full
                         bg-green-400
                         shadow-lg shadow-green-400/50">

            </span>

        @endif


    </div>





    {{-- Last Message --}}


    <div class="text-sm text-slate-400 mt-1 truncate">


        @if($lastMessage)


            @if($lastMessage->user_id == auth()->id())

                <span class="text-indigo-300">

                    You:

                </span>

            @endif



            {{ \Illuminate\Support\Str::limit($lastMessage->message,40) }}



        @else


            No messages yet


        @endif


    </div>





    {{-- Time --}}


    @if($lastMessage)


    <div class="text-xs text-slate-500 mt-2">


        {{ $lastMessage->created_at->diffForHumans() }}


    </div>


    @endif



</div>



</div>



</a>



@empty



<div class="rounded-3xl bg-white/5
    border border-white/10
    p-8 text-center">


<div class="text-5xl mb-4">

💬

</div>



<h3 class="font-bold text-lg">

No Conversations

</h3>



<p class="text-slate-400 mt-2 text-sm">

Start a new conversation with your team.

</p>



<a href="{{ route('chat.users') }}"
class="inline-flex mt-5
      px-5 py-3 rounded-2xl
      bg-gradient-to-r from-indigo-500 to-violet-600
      font-semibold shadow-lg">


Start Chat


</a>


</div>



@endforelse



</div>


</div>
{{-- Main Area --}}


<div class="flex-1 flex items-center justify-center
            bg-gradient-to-br from-slate-100 via-white to-indigo-50">



    <div class="text-center">



        <div class="w-32 h-32 mx-auto rounded-3xl
                    bg-gradient-to-br from-indigo-500 to-violet-600
                    flex items-center justify-center
                    text-6xl shadow-2xl mb-6">


            💬


        </div>





        <h2 class="text-3xl font-black text-slate-800 mb-3">


            Welcome to ERP Chat


        </h2>





        <p class="text-slate-500 text-lg max-w-md">


            Select a conversation from the sidebar
            or start a new chat with your team.


        </p>





        <a href="{{ route('chat.users') }}"
           class="inline-flex items-center gap-3
                  mt-8 px-7 py-4 rounded-2xl
                  bg-gradient-to-r from-indigo-600 to-violet-600
                  text-white font-bold
                  shadow-xl hover:scale-105 transition">


            ➕ Start New Conversation


        </a>




    </div>


</div>




</div>


@endsection