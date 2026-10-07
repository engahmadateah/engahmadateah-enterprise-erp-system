<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;




class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')
            ->latest()
            ->paginate(15);

        return view(
            'attendance.index',
            compact('attendances')
        );
    }

    public function create()
    {
        $employees = Employee::orderBy('first_name')
            ->get();

        return view(
            'attendance.create',
            compact('employees')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required|exists:employees,id',

            'attendance_date' => 'required|date',

            'check_in' => 'nullable|date_format:H:i,H:i:s',

            'check_out' => 'nullable|date_format:H:i,H:i:s',

            'status' => 'required|in:present,absent,late,leave',

            'notes' => 'nullable|string|max:500',

        ]);

        Attendance::create($request->only([
            'employee_id', 'attendance_date', 'check_in',
            'check_out', 'status', 'notes',
        ]));

        return redirect()
            ->route('attendance.index')
            ->with(
                'success',
                'Attendance Created Successfully'
            );
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();

        return view(
            'attendance.edit',
            compact(
                'attendance',
                'employees'
            )
        );
    }

    public function update(
        Request $request,
        Attendance $attendance
    )
    {
        $request->validate([

            'employee_id' => 'required|exists:employees,id',

            'attendance_date' => 'required|date',

            'check_in' => 'nullable|date_format:H:i,H:i:s',

            'check_out' => 'nullable|date_format:H:i,H:i:s',

            'status' => 'required|in:present,absent,late,leave',

            'notes' => 'nullable|string|max:500',

        ]);

        $attendance->update($request->only([
            'employee_id', 'attendance_date', 'check_in',
            'check_out', 'status', 'notes',
        ]));

        return redirect()
            ->route('attendance.index')
            ->with(
                'success',
                'Attendance Updated Successfully'
            );
    }

    public function destroy(
        Attendance $attendance
    )
    {
        $attendance->delete();

        return back()->with(
            'success',
            'Attendance Deleted Successfully'
        );
    }
    public function dailySheet(Request $request)
{
    $date = $request->date ?? now()->toDateString();

    $employees = Employee::with('department')
        ->where('is_active', 1)
        ->orderBy('first_name')
        ->get();

    $attendances = Attendance::whereDate(
        'attendance_date',
        $date
    )->get()
    ->keyBy('employee_id');

    return view(
        'attendance.daily-sheet',
        compact(
            'employees',
            'date',
            'attendances'
        )
    );
}
public function saveDailySheet(Request $request)
{
    $request->validate([
        'attendance_date' => 'required|date',
        'employees' => 'required|array',
        'employees.*.status' => 'nullable|in:present,absent,late,leave',
        'employees.*.check_in' => 'nullable|date_format:H:i,H:i:s',
        'employees.*.check_out' => 'nullable|date_format:H:i,H:i:s',
        'employees.*.notes' => 'nullable|string|max:500',
    ]);

    $date = $request->attendance_date;

    $validIds = Employee::whereIn('id', array_keys($request->employees))
        ->pluck('id')->all();

    foreach ($request->employees as $employeeId => $data) {

        if (! in_array((int) $employeeId, $validIds, true)) {
            continue;
        }

        Attendance::updateOrCreate(

            [
                'employee_id' => $employeeId,
                'attendance_date' => $date
            ],

            [
                'check_in' => $data['check_in'] ?? null,
                'check_out' => $data['check_out'] ?? null,
                'status' => $data['status'] ?? 'present',
                'notes' => $data['notes'] ?? null,
            ]

        );
    }

    return redirect()
        ->back()
        ->with(
            'success',
            'Attendance Saved Successfully'
        );
}
}