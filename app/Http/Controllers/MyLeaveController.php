<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyLeaveController extends Controller
{
    /** The logged-in user must be linked to an employee record. */
    private function employeeOrFail()
    {
        $employee = auth()->user()->employee;

        abort_unless(
            $employee,
            403,
            'Your account is not linked to an employee record.'
        );

        return $employee;
    }

    public function index()
    {
        $employee = $this->employeeOrFail();

        $balance = $employee->leaveBalance;

        $leaves = Leave::with('leaveType')
            ->where('employee_id', $employee->id)
            ->latest()
            ->paginate(20);

        return view('leaves.my.index', compact('leaves', 'balance'));
    }

    public function create()
    {
        $this->employeeOrFail();

        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('leaves.my.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $employee = $this->employeeOrFail();

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'reason'        => 'required|string|max:1000',
        ]);

        $days = Carbon::parse($request->start_date)
            ->diffInDays(Carbon::parse($request->end_date)) + 1;

        $balance   = LeaveBalance::where('employee_id', $employee->id)->first();
        $leaveType = LeaveType::findOrFail($request->leave_type_id);

        if (
            $leaveType->is_deducted
            && $balance
            && $days > $balance->remaining_balance
        ) {
            return back()->withInput()->with('error', 'Not enough leave balance');
        }

        Leave::create([
            'employee_id'   => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'days'          => $days,
            'reason'        => $request->reason,
            'status'        => 'pending',
        ]);

        return redirect()
            ->route('my-leaves.index')
            ->with('success', 'Leave Request Submitted');
    }
}
