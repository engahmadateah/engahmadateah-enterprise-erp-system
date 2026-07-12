<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LeaveType;
use App\Models\LeaveBalance;

class MyLeaveController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;

        $balance = $employee->leaveBalance;

        $leaves = Leave::where(
            'employee_id',
            $employee->id
        )
        ->latest()
        ->paginate(20);

        return view(
            'leaves.my.index',
            compact(
                'leaves',
                'balance'
            )
        );
    }

    public function create()
{
    $leaveTypes = LeaveType::orderBy('name')->get();

    return view(
        'leaves.my.create',
        compact('leaveTypes')
    );
}

    public function store(Request $request)
    {
        $request->validate([

            'leave_type_id' => 'required|exists:leave_types,id',


            'start_date' => 'required|date',

            'end_date' => 'required|date',

            'reason' => 'required',

        ]);

        $employee = auth()
            ->user()
            ->employee;

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
        
        $leaveType = LeaveType::findOrFail(
            $request->leave_type_id
        );
        
        if (
            $leaveType->is_deducted &&
            $balance &&
            $days > $balance->remaining_balance
        ) {
            return back()->with(
                'error',
                'Not enough leave balance'
            );
        }
      
        
       

        Leave::create([

            'employee_id' =>
                $employee->id,

            'leave_type_id' =>
                $request->leave_type_id,

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
}