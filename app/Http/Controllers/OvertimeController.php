<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Http\Request;



class OvertimeController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with('employee')
            ->latest()
            ->paginate(20);

        return view(
            'overtimes.index',
            compact('overtimes')
        );
    }

    public function create()
    {
        $employees = Employee::orderBy('first_name')
            ->get();

        return view(
            'overtimes.create',
            compact('employees')
        );
    }
    public function store(Request $request)
{
    $request->validate([

        'employee_id' => 'required|exists:employees,id',

        'date' => 'required|date',

        'hours' => 'required|numeric|min:0.5',

    ]);

    $employee = Employee::findOrFail(
        $request->employee_id
    );

    $dailyRate =
        $employee->salary / 30;

    $hourRate =
        $dailyRate / 8;

    $totalAmount =
        $hourRate * $request->hours;

    Overtime::create([

        'employee_id' => $employee->id,

        'date' => $request->date,

        'hours' => $request->hours,

        'hour_rate' => $hourRate,

        'total_amount' => $totalAmount,

        'notes' => $request->notes,

    ]);

    return redirect()
        ->route('overtimes.index')
        ->with(
            'success',
            'Overtime Added Successfully'
        );
}
}