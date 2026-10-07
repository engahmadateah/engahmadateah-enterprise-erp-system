@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6">

<div class="bg-white rounded shadow">

<div class="p-4 border-b">

<h2 class="text-2xl font-bold">

Employees

</h2>

<form method="GET">

<input
type="text"
name="search"
placeholder="Search employee..."
class="w-full border rounded p-3 mt-4">

</form>

</div>

@foreach($users as $user)

<div class="flex justify-between items-center p-4 border-b">

<div>

<div class="font-semibold">

{{ $user->name }}

</div>

<div class="text-gray-500">

{{ $user->email }}

</div>

</div>

<form method="POST" action="{{ route('chat.start', $user) }}">@csrf<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Start Chat</button></form>

</div>

@endforeach

</div>

</div>

@endsection