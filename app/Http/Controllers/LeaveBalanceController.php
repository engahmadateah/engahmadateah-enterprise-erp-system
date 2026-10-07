<?php

namespace App\Http\Controllers;

use App\Models\LeaveBalance;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function index()
    {
        $balances = LeaveBalance::with(
            'employee'
        )->paginate(20);

        return view(
            'leave-balances.index',
            compact('balances')
        );
    }

    public function edit(
        LeaveBalance $leaveBalance
    )
    {
        return view(
            'leave-balances.edit',
            compact('leaveBalance')
        );
    }

    public function update(
        Request $request,
        LeaveBalance $leaveBalance
    )
    {
        $request->validate([

            'annual_balance' =>
                'required|integer|min:0|max:366'
        ]);

        $used = $leaveBalance->used_balance;

        if ($request->annual_balance < $used) {
            return back()->withInput()->with(
                'error',
                'Balance cannot be lower than the days already used.'
            );
        }

        $leaveBalance->update([

            'annual_balance' =>
                $request->annual_balance,

            'remaining_balance' =>
                $request->annual_balance - $used,

        ]);

        return redirect()
            ->route(
                'leave-balances.index'
            )
            ->with(
                'success',
                'Balance Updated'
            );
    }
}