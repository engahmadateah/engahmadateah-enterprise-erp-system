@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6">

<div class="bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-6">

Generate Payroll

</h2>

<form method="POST"
      action="{{ route('payroll.store') }}">

@csrf

<select
name="employee_id"
class="w-full border p-3 rounded mb-4">

@foreach($employees as $employee)

<option value="{{ $employee->id }}">

{{ $employee->first_name }}
{{ $employee->last_name }}

</option>

@endforeach

</select>

<input
type="number"
name="month"
placeholder="Month"
class="w-full border p-3 rounded mb-4">

<input
type="number"
name="year"
placeholder="Year"
class="w-full border p-3 rounded mb-4">

<button
class="bg-green-600 text-white px-4 py-2 rounded">

Generate Payroll

</button>

</form>

</div>

</div>

@endsection