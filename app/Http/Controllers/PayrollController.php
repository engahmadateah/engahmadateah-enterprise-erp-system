<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Attendance;
use App\Models\Bonus;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Services\AccountingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PayrollController extends Controller
{
    public function create()
    {
        $employees = Employee::where('is_active', true)
            ->orderBy('first_name')
            ->get();

        return view('payroll.create', compact('employees'));
    }

    /**
     * Payroll for ONE employee.
     */
    public function store(Request $request, AccountingService $accounting)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month'       => 'required|integer|between:1,12',
            'year'        => 'required|integer|between:2000,2100',
        ]);

        $employee = Employee::findOrFail($data['employee_id']);

        try {
            DB::transaction(function () use ($employee, $data, $accounting) {
                $this->generateFor($employee, (int) $data['month'], (int) $data['year'], $accounting);
            });
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Payroll Generated');
    }

    /**
     * Payroll for ALL active employees.
     */
    public function generateMonthlyPayroll(Request $request, AccountingService $accounting)
    {
        $data = $request->validate([
            'month' => 'required|integer|between:1,12',
            'year'  => 'required|integer|between:2000,2100',
        ]);

        try {
            DB::transaction(function () use ($data, $accounting) {
                Employee::where('is_active', true)->each(
                    fn ($employee) => $this->generateFor(
                        $employee,
                        (int) $data['month'],
                        (int) $data['year'],
                        $accounting
                    )
                );
            });
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Payroll Generated for All Employees');
    }

    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->latest()
            ->paginate(20);

        return view('payroll.index', compact('payrolls'));
    }

    public function slip($id)
    {
        $payroll = Payroll::with('employee.department')->findOrFail($id);

        // HR/Accounting (payroll.view) or the employee that owns this slip
        $isOwner = $payroll->employee
            && $payroll->employee->user_id === auth()->id();

        abort_unless($isOwner || auth()->user()->can('payroll.view'), 403);

        $pdf = Pdf::loadView('payroll.slip', ['payroll' => $payroll]);

        return $pdf->download(
            'salary-slip-' . $payroll->employee->employee_no . '.pdf'
        );
    }

    /**
     * Minimal check that a payroll record exists (used by the QR / verify link).
     * Never exposes salary figures.
     */
    public function verify($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);

        return response()->json([
            'valid'       => true,
            'employee_no' => $payroll->employee->employee_no,
            'period'      => sprintf('%04d-%02d', $payroll->year, $payroll->month),
        ]);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Calculate + save one payroll row (idempotent per employee/month/year).
     * Loans and the journal entry are applied only the first time the row is
     * created, so re-generating a month never double-charges a loan or
     * double-posts the accounting entry.
     */
    private function generateFor(
        Employee $employee,
        int $month,
        int $year,
        AccountingService $accounting
    ): Payroll {

        $salary      = (float) $employee->salary;
        $dailySalary = $salary / 30;

        $presentDays = Attendance::where('employee_id', $employee->id)
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->whereIn('status', ['present', 'late'])
            ->count();

        $attendanceSalary = $dailySalary * $presentDays;

        $inMonth = fn ($model) => $model::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year);

        $advances       = $inMonth(Advance::class)->sum('amount');
        $bonusAmount    = $inMonth(Bonus::class)->sum('amount');
        $overtimeAmount = $inMonth(Overtime::class)->sum('total_amount');

        // never deduct more than what is still owed on a loan
        $openLoans = Loan::where('employee_id', $employee->id)
            ->where('is_closed', false)
            ->get();

        $loanDeduction = $openLoans->sum(
            fn ($loan) => min($loan->monthly_installment, $loan->remaining_balance)
        );

        $netSalary = $attendanceSalary
            + $bonusAmount
            + $overtimeAmount
            - $advances
            - $loanDeduction;

        $payroll = Payroll::updateOrCreate(
            [
                'employee_id' => $employee->id,
                'month'       => $month,
                'year'        => $year,
            ],
            [
                'basic_salary'      => $salary,
                'attendance_salary' => $attendanceSalary,
                'bonus_amount'      => $bonusAmount,
                'overtime_amount'   => $overtimeAmount,
                'advance_deduction' => $advances,
                'loan_deduction'    => $loanDeduction,
                'net_salary'        => $netSalary,
            ]
        );

        if ($payroll->wasRecentlyCreated) {

            foreach ($openLoans as $loan) {
                $paid = min($loan->monthly_installment, $loan->remaining_balance);
                $left = $loan->remaining_balance - $paid;

                $loan->update([
                    'remaining_balance' => $left,
                    'is_closed'         => $left <= 0,
                ]);
            }

            if ($netSalary > 0) {
                $acc = $accounting->accounts(['5000', '1000']);

                $accounting->createEntry(
                    'Payroll ' . $employee->first_name . ' ' . $employee->last_name
                        . " ({$month}/{$year})",
                    auth()->id(),
                    [
                        ['account_id' => $acc['5000']->id, 'debit'  => $netSalary],
                        ['account_id' => $acc['1000']->id, 'credit' => $netSalary],
                    ]
                );
            }
        }

        return $payroll;
    }
}
