<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Employee;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        $bonuses = Bonus::with('employee')
            ->latest()
            ->paginate(20);

        return view(
            'bonuses.index',
            compact('bonuses')
        );
    }

    public function create()
    {
        $employees = Employee::all();

        return view(
            'bonuses.create',
            compact('employees')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'amount' => 'required',

            'reason' => 'required',

            'date' => 'required'

        ]);

        Bonus::create([
            'employee_id' => $request->employee_id,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'reason'      => $request->reason,
        ]);

        return redirect()
            ->route('bonuses.index')
            ->with(
                'success',
                'Bonus Added'
            );
    }
}