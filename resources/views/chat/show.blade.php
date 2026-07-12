@extends('layouts.app')

@section('content')

<div class="flex h-screen overflow-hidden
            bg-slate-100">



{{-- ================= SIDEBAR ================= --}}


<div class="w-80
            bg-gradient-to-b from-slate-950 via-slate-900 to-indigo-950
            text-white flex flex-col shadow-2xl">





    {{-- Header --}}


    <div class="p-6 border-b border-white/10">


        <div class="flex items-center gap-4">


            <div class="w-14 h-14 rounded-3xl
                        bg-gradient-to-br from-indigo-500 to-violet-600
                        flex items-center justify-center
                        text-2xl shadow-xl">

                💬

            </div>




            <div>


                <h2 class="text-2xl font-black">

                    Messages

                </h2>


                <p class="text-sm text-slate-400">

                    ERP Team Chat

                </p>


            </div>



        </div>


    </div>







    {{-- Conversations List --}}


    <div class="flex-1 overflow-y-auto p-4 space-y-3">



        @foreach(auth()->user()->conversations as $item)



            @php

                $sidebarUser =
                    $item->users
                    ->where('id','!=',auth()->id())
                    ->first();

            @endphp





            <a href="{{ route('chat.show',$item) }}"
               class="flex items-center gap-4
                      p-4 rounded-3xl
                      bg-white/5
                      border border-white/5
                      hover:bg-indigo-600/30
                      transition">






                <div class="w-14 h-14 rounded-2xl
                            bg-gradient-to-br from-indigo-500 to-violet-600
                            flex items-center justify-center
                            font-bold text-xl shadow-lg">


                    {{ strtoupper(substr($sidebarUser?->name ?? 'U',0,1)) }}


                </div>





                <div class="flex-1 min-w-0">


                    <div class="font-bold truncate">


                        {{ $sidebarUser?->name ?? 'User' }}


                    </div>



                    <div class="text-xs text-slate-400">


                        Conversation


                    </div>


                </div>




            </a>



        @endforeach



    </div>



</div>
{{-- ================= CHAT AREA ================= --}}


<div class="flex-1 flex flex-col min-w-0">





{{-- Chat Header --}}


<div class="bg-white
            border-b border-slate-200
            px-8 py-6
            shadow-sm
            flex-shrink-0">



@php

$otherUser =
    $conversation->users
    ->where('id','!=',auth()->id())
    ->first();

@endphp






<div class="flex items-center gap-5">





<div class="w-16 h-16 rounded-3xl
            bg-gradient-to-br from-indigo-500 to-violet-600
            text-white
            flex items-center justify-center
            font-black text-2xl
            shadow-xl">


{{ strtoupper(substr($otherUser?->name ?? 'U',0,1)) }}


</div>






<div>


<h2 class="text-3xl font-black text-slate-800">


{{ $otherUser?->name }}


</h2>




<div class="flex items-center gap-2 mt-1">


<span class="w-3 h-3 rounded-full bg-green-500"></span>


<p class="text-sm text-slate-500">

Online • ERP Chat

</p>


</div>



</div>




</div>



</div>









{{-- Messages Area --}}


<div id="messagesBox"
     class="flex-1 overflow-y-auto
            px-10 py-8
            bg-gradient-to-br from-slate-100 via-white to-indigo-50">





<div class="space-y-8">



@foreach($messages as $message)



@if($message->user_id == auth()->id())





{{-- My Message --}}


<div class="flex justify-end">



<div class="max-w-3xl
            bg-gradient-to-r
            from-indigo-600
            to-violet-600
            text-white
            rounded-3xl
            rounded-br-lg
            px-7 py-5
            shadow-xl">





@if($message->message)


<p class="text-lg leading-relaxed">

{{ $message->message }}

</p>


@endif







@if($message->attachment)


@php

$ext = strtolower(
    pathinfo(
        $message->attachment,
        PATHINFO_EXTENSION
    )
);

@endphp





@if(in_array($ext,['jpg','jpeg','png','gif','webp']))


<a href="{{ asset('storage/'.$message->attachment) }}"
   target="_blank"
   class="block mt-5">


<img src="{{ asset('storage/'.$message->attachment) }}"
     class="rounded-3xl max-w-md shadow-xl">


</a>



@else


<a href="{{ asset('storage/'.$message->attachment) }}"
   target="_blank"
   class="inline-flex items-center gap-2
          mt-5 px-5 py-3
          rounded-2xl
          bg-white/20">


📎 Download File


</a>



@endif


@endif






<div class="text-xs mt-4 text-indigo-100">


{{ $message->created_at->format('H:i') }}


</div>




</div>



</div>






@else





{{-- Other Message --}}


<div class="flex justify-start">



<div class="max-w-3xl
            bg-white
            rounded-3xl
            rounded-bl-lg
            px-7 py-5
            shadow-xl
            border border-slate-100">





<div class="font-black
            text-slate-800
            text-lg
            mb-3">


{{ $message->user->name }}


</div>






@if($message->message)


<p class="text-lg text-slate-700">


{{ $message->message }}


</p>


@endif
@if($message->attachment)


@php

$ext = strtolower(
    pathinfo(
        $message->attachment,
        PATHINFO_EXTENSION
    )
);

@endphp






@if(in_array($ext,['jpg','jpeg','png','gif','webp']))


<a href="{{ asset('storage/'.$message->attachment) }}"
   target="_blank"
   class="block mt-5">


<img src="{{ asset('storage/'.$message->attachment) }}"
     class="rounded-3xl max-w-md shadow-lg">


</a>



@else


<a href="{{ asset('storage/'.$message->attachment) }}"
   target="_blank"
   class="inline-flex items-center gap-3
          mt-5 px-5 py-3
          rounded-2xl
          bg-indigo-100
          text-indigo-700
          font-bold">


📎 Download File


</a>



@endif


@endif







<div class="text-xs text-slate-400 mt-4">


{{ $message->created_at->format('H:i') }}


</div>





</div>



</div>





@endif



@endforeach



</div>



</div>









{{-- ================= SEND BOX FIXED ================= --}}



<form
method="POST"
action="{{ route('chat.send',$conversation) }}"
enctype="multipart/form-data"
class="bg-white
       border-t border-slate-200
       px-8 py-5
       shadow-2xl
       flex-shrink-0">



@csrf





<div class="flex items-center gap-4">





<input
type="text"
name="message"
class="flex-1
       px-7 py-5
       rounded-3xl
       border border-slate-200
       text-lg
       shadow-sm
       focus:ring-2
       focus:ring-indigo-500
       focus:outline-none"
placeholder="Write a message...">







<label
class="w-16 h-16
       rounded-3xl
       bg-slate-100
       hover:bg-slate-200
       flex items-center justify-center
       text-2xl
       cursor-pointer
       transition">


📎


<input
type="file"
name="attachment"
class="hidden">


</label>







<button
class="px-10 py-5
       rounded-3xl
       bg-gradient-to-r
       from-indigo-600
       to-violet-600
       text-white
       font-black
       text-lg
       shadow-xl
       hover:scale-105
       transition">


Send 🚀


</button>




</div>



</form>







</div>




</div>





{{-- Auto scroll to latest message --}}


<script>

document.addEventListener("DOMContentLoaded", function(){

    let box = document.getElementById('messagesBox');

    if(box){

        box.scrollTop = box.scrollHeight;

    }

});

</script>



@endsection