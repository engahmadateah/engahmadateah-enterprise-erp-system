@extends('layouts.app')

@section('content')

<div class="p-6">

    <h2 class="text-3xl font-bold mb-6">

        Welcome

        {{ $employee->first_name }}

    </h2>

    <div class="grid grid-cols-3 gap-4">

        <div class="bg-white shadow rounded p-6">

            <h3 class="font-bold">

                Leave Balance

            </h3>

            <p class="text-4xl">

                {{ $leaveBalance }}

            </p>

        </div>

        <div class="bg-white shadow rounded p-6">

            <h3 class="font-bold">

                Pending Leaves

            </h3>

            <p class="text-4xl">

                {{ $pendingLeaves }}

            </p>

        </div>

        <div class="bg-white shadow rounded p-6">

            <h3 class="font-bold">

                Approved Leaves

            </h3>

            <p class="text-4xl">

                {{ $approvedLeaves }}

            </p>

        </div>

    </div>

</div>

@endsection