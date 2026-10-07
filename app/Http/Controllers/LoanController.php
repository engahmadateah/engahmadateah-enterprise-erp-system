<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Employee;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('employee')
            ->latest()
            ->paginate(20);

        return view(
            'loans.index',
            compact('loans')
        );
    }

    public function create()
    {
        $employees = Employee::all();

        return view(
            'loans.create',
            compact('employees')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'         => 'required|exists:employees,id',
            'amount'              => 'required|numeric|min:0.01|max:999999999',
            // an installment bigger than the loan makes no sense
            'monthly_installment' => 'required|numeric|min:0.01|lte:amount',
            'start_date'          => 'required|date',
            'notes'               => 'nullable|string|max:500',
        ]);

        Loan::create([

            'employee_id' => $request->employee_id,

            'amount' => $request->amount,

            'monthly_installment' =>
                $request->monthly_installment,

            'remaining_balance' =>
                $request->amount,

            'start_date' =>
                $request->start_date,

            'notes' =>
                $request->notes

        ]);

        return redirect()
            ->route('loans.index')
            ->with(
                'success',
                'Loan Created Successfully'
            );
    }
}