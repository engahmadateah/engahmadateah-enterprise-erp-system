@extends('layouts.app')

@section('title','Generate Payroll')

@section('content')

<div class="max-w-xl mx-auto p-6">

    <div class="bg-white rounded shadow p-6">

        <h2 class="text-2xl font-bold mb-6">

            Generate Payroll

        </h2>

        <form method="POST"
              action="{{ route('payroll.generate') }}">

            @csrf

            <div class="mb-4">

                <label class="block mb-2">

                    Month

                </label>

                <select
                    name="month"
                    class="w-full border rounded p-2">

                    @for($i=1;$i<=12;$i++)

                        <option value="{{ $i }}">
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

            <div class="mb-4">

                <label class="block mb-2">

                    Year

                </label>

                <input
                    type="number"
                    name="year"
                    value="{{ now()->year }}"
                    class="w-full border rounded p-2">

            </div>

            <button
                class="bg-green-600 text-white px-6 py-2 rounded">

                Generate

            </button>

        </form>

    </div>

</div>

@endsection