<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\DB;

/**
 * HR side of leaves (list / approve / reject).
 * Employee requests live in MyLeaveController.
 */
class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('employee', 'leaveType')
            ->latest()
            ->paginate(20);

        return view('leaves.index', compact('leaves'));
    }

    public function approve(Leave $leave)
    {
        if ($leave->employee && $leave->employee->user_id === auth()->id()
            && ! auth()->user()->hasRole('Super Admin')) {
            return back()->with('error', 'You cannot approve your own leave request.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request was already processed.');
        }

        $error = null;

        DB::transaction(function () use ($leave, &$error) {

            if ($leave->leaveType && $leave->leaveType->is_deducted) {

                $balance = LeaveBalance::where('employee_id', $leave->employee_id)
                    ->lockForUpdate()
                    ->first();

                if ($balance) {
                    // balance may have changed since the request was submitted
                    if ($leave->days > $balance->remaining_balance) {
                        $error = 'Not enough leave balance';
                        return;
                    }

                    $balance->update([
                        'used_balance'      => $balance->used_balance + $leave->days,
                        'remaining_balance' => $balance->remaining_balance - $leave->days,
                    ]);
                }
            }

            $leave->update([
                'status'      => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        if ($error) {
            return back()->with('error', $error);
        }

        return back()->with('success', 'Leave Approved');
    }

    public function reject(Leave $leave)
    {
        if ($leave->employee && $leave->employee->user_id === auth()->id()
            && ! auth()->user()->hasRole('Super Admin')) {
            return back()->with('error', 'You cannot process your own leave request.');
        }

        // an approved leave already consumed balance; rejecting it here would
        // leave the balance wrong, so only pending requests can be rejected
        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request was already processed.');
        }

        $leave->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Leave Rejected');
    }
}
