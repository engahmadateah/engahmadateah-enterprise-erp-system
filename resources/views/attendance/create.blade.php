@extends('layouts.app')

@section('title', 'Add Attendance')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">
        Add Attendance
    </h2>

    <form method="POST"
          action="{{ route('attendance.store') }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf

        <div>
            <label class="block mb-2">
                Employee
            </label>

            <select name="employee_id"
                    class="w-full border rounded p-2">

                <option value="">
                    Select Employee
                </option>

                @foreach($employees as $employee)

                    <option value="{{ $employee->id }}">

                        {{ $employee->employee_no }}
                        -
                        {{ $employee->first_name }}
                        {{ $employee->last_name }}

                    </option>

                @endforeach

            </select>
        </div>

        <div>
            <label class="block mb-2">
                Attendance Date
            </label>

            <input type="date"
                   name="attendance_date"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-2">
                Check In
            </label>

            <input type="time"
                   name="check_in"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-2">
                Check Out
            </label>

            <input type="time"
                   name="check_out"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-2">
                Status
            </label>

            <select name="status"
                    class="w-full border rounded p-2">

                <option value="present">
                    Present
                </option>

                <option value="late">
                    Late
                </option>

                <option value="absent">
                    Absent
                </option>

                <option value="leave">
                    Leave
                </option>

            </select>
        </div>

        <div>
            <label class="block mb-2">
                Notes
            </label>

            <textarea name="notes"
                      rows="4"
                      class="w-full border rounded p-2"></textarea>
        </div>

        <button
            class="bg-blue-600 text-white px-5 py-2 rounded">

            Save Attendance

        </button>

    </form>

</div>

@endsection