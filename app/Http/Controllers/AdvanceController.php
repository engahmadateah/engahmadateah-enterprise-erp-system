<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
    public function index()
    {
        $advances = Advance::with('employee')
            ->latest()
            ->paginate(20);

        return view(
            'advances.index',
            compact('advances')
        );
    }

    public function create()
    {
        $employees = Employee::all();

        return view(
            'advances.create',
            compact('employees')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'amount' => 'required|numeric',

            'date' => 'required|date',

        ]);

        Advance::create([

            'employee_id' => $request->employee_id,

            'amount' => $request->amount,

            'date' => $request->date,

            'notes' => $request->notes,

        ]);

        return redirect()
            ->route('advances.index')
            ->with(
                'success',
                'Advance Added Successfully'
            );
    }
}