<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LeaveType;

class LeaveController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Employee Requests
    |--------------------------------------------------------------------------
    */

    public function myLeaves()
    {
        $employee = auth()
            ->user()
            ->employee;

        $leaves = Leave::where(
            'employee_id',
            $employee->id
        )
        ->latest()
        ->get();

        return view(
            'leaves.my-leaves',
            compact(
                'employee',
                'leaves'
            )
        );
    }

    public function create()
{
    $leaveTypes = LeaveType::orderBy('name')->get();

    return view('leaves.create', compact('leaveTypes'));
}

    public function store(Request $request)
    {
        $employee = auth()
            ->user()
            ->employee;

        $request->validate([

            'leave_type_id' => 'required',

            'start_date' => 'required|date',

            'end_date' => 'required|date',

            'reason' => 'nullable'

        ]);

        $days = Carbon::parse(
            $request->start_date
        )->diffInDays(
            Carbon::parse(
                $request->end_date
            )
        ) + 1;

        $balance = LeaveBalance::where(
            'employee_id',
            $employee->id
        )->first();

        if (
            $request->leave_type_id == 'annual'
            &&
            $balance
            &&
            $days > $balance->remaining_balance
        ) {

            return back()
                ->with(
                    'error',
                    'Not enough leave balance'
                );
        }
        
        Leave::create([

            'employee_id' =>
                $employee->id,

            'leave_type_id' => $request->leave_type_id,

            'start_date' =>
                $request->start_date,

            'end_date' =>
                $request->end_date,

            'days' =>
                $days,

            'reason' =>
                $request->reason,

            'status' =>
                'pending',

        ]);

        return redirect()
            ->route(
                'my-leaves.index'
            )
            ->with(
                'success',
                'Leave Request Submitted'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HR Requests
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $leaves = Leave::with(
            'employee'
        )
        ->latest()
        ->paginate(20);

        return view(
            'leaves.index',
            compact('leaves')
        );
    }

    public function approve(
        
        Leave $leave
    )
    {
        if (
            $leave->status != 'pending'
        ) {
            return back();
        }

        /*
        |--------------------------------------------------------------------------
        | Deduct Annual Leave Only
        |--------------------------------------------------------------------------
        */

        if (
            $leave->leaveType &&
            $leave->leaveType->is_deducted
        ) {

            $balance = LeaveBalance::where(
                'employee_id',
                $leave->employee_id
            )->first();

            if ($balance) {

                $balance->update([

                    'used_balance' =>
                        $balance->used_balance
                        + $leave->days,

                    'remaining_balance' =>
                        $balance->remaining_balance
                        - $leave->days,

                ]);
            }
        }

        $leave->update([

            'status' =>
                'approved',

            'approved_by' =>
                auth()->id(),

            'approved_at' =>
                now(),

        ]);

        return back()
            ->with(
                'success',
                'Leave Approved'
            );
    }

    public function reject(
        Leave $leave
    )
    {
        $leave->update([

            'status' =>
                'rejected',

            'approved_by' =>
                auth()->id(),

            'approved_at' =>
                now(),

        ]);

        return back()
            ->with(
                'success',
                'Leave Rejected'
            );
    }
}