<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Advance;
use App\Models\Loan;
use App\Models\Bonus;
use App\Models\Overtime;
use App\Models\Account;
use App\Services\AccountingService;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PayrollController extends Controller
{
    public function create()
    {
        $employees = Employee::all();

        return view(
            'payroll.create',
            compact('employees')
        );
    }

    public function store(Request $request)
    {
        $employee = Employee::findOrFail(
            $request->employee_id
        );

        $month = $request->month;
        $year  = $request->year;

        $salary = $employee->salary;

        $dailySalary = $salary / 30;

        $presentDays = Attendance::where(
            'employee_id',
            $employee->id
        )
        ->whereMonth(
            'attendance_date',
            $month
        )
        ->whereYear(
            'attendance_date',
            $year
        )
        ->whereIn(
            'status',
            ['present', 'late']
        )
        ->count();

        $attendanceSalary = $dailySalary * $presentDays;

        $advances = Advance::where(
            'employee_id',
            $employee->id
        )
        ->whereMonth(
            'date',
            $month
        )
        ->whereYear(
            'date',
            $year
        )
        ->sum('amount');

        $loanDeduction = Loan::where(
            'employee_id',
            $employee->id
        )
        ->where('is_closed', false)
        ->sum('monthly_installment');

        $bonusAmount = Bonus::where(
            'employee_id',
            $employee->id
        )
        ->whereMonth(
            'date',
            $month
        )
        ->whereYear(
            'date',
            $year
        )
        ->sum('amount');

        $overtimeAmount = Overtime::where(
            'employee_id',
            $employee->id
        )
        ->whereMonth(
            'date',
            $month
        )
        ->whereYear(
            'date',
            $year
        )
        ->sum('total_amount');

        $netSalary =
            $attendanceSalary
            + $bonusAmount
            + $overtimeAmount
            - $advances
            - $loanDeduction;

        Payroll::create([

            'employee_id'        => $employee->id,

            'month'              => $month,

            'year'               => $year,

            'basic_salary'       => $salary,

            'attendance_salary'  => $attendanceSalary,

            'bonus_amount'       => $bonusAmount,

            'overtime_amount'    => $overtimeAmount,

            'advance_deduction'  => $advances,

            'loan_deduction'     => $loanDeduction,

            'net_salary'         => $netSalary

        ]);
        $salaryExpense = Account::where(
            'code',
            '5000'
        )->first();
        
        $cashAccount = Account::where(
            'code',
            '1000'
        )->first();
        
        $entry = JournalEntry::create([
        
            'entry_number' =>
                'JE-' . date('YmdHis'),
        
            'entry_date' =>
                now(),
        
            'description' =>
                'Payroll '.$employee->name,
        
            'user_id' =>
                auth()->id()
        
        ]);
        JournalEntryLine::create([

            'journal_entry_id' =>
                $entry->id,
        
            'account_id' =>
                $salaryExpense->id,
        
            'debit' =>
                $netSalary,
        
            'credit' =>
                0
        
        ]);
        JournalEntryLine::create([

            'journal_entry_id' =>
                $entry->id,
        
            'account_id' =>
                $cashAccount->id,
        
            'debit' =>
                0,
        
            'credit' =>
                $netSalary
        
        ]);

        return redirect()
            ->route('payroll.index');
    }
    
    public function generateMonthlyPayroll(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;

        $employees = Employee::all();

        foreach ($employees as $employee) {

            $salary = $employee->salary;

            $dailySalary = $salary / 30;

            $presentDays = Attendance::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'attendance_date',
                $month
            )
            ->whereYear(
                'attendance_date',
                $year
            )
            ->whereIn(
                'status',
                ['present', 'late']
            )
            ->count();

            $attendanceSalary =
                $dailySalary * $presentDays;

            $advances = Advance::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'date',
                $month
            )
            ->whereYear(
                'date',
                $year
            )
            ->sum('amount');

            $bonusAmount = Bonus::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'date',
                $month
            )
            ->whereYear(
                'date',
                $year
            )
            ->sum('amount');

            $overtimeAmount = Overtime::where(
                'employee_id',
                $employee->id
            )
            ->whereMonth(
                'date',
                $month
            )
            ->whereYear(
                'date',
                $year
            )
            ->sum('total_amount');

            $loanDeduction = Loan::where(
                'employee_id',
                $employee->id
            )
            ->where('is_closed', false)
            ->sum('monthly_installment');

            $netSalary =
                $attendanceSalary
                + $bonusAmount
                + $overtimeAmount
                - $advances
                - $loanDeduction;

            Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'month'       => $month,
                    'year'        => $year
                ],
                [
                    'basic_salary'       => $salary,

                    'attendance_salary'  => $attendanceSalary,

                    'bonus_amount'       => $bonusAmount,

                    'overtime_amount'    => $overtimeAmount,

                    'advance_deduction'  => $advances,

                    'loan_deduction'     => $loanDeduction,

                    'net_salary'         => $netSalary,
                ]
            );
        }

        return redirect()
            ->route('payroll.index')
            ->with(
                'success',
                'Payroll Generated for All Employees'
            );
    }

    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->latest()
            ->paginate(20);

        return view(
            'payroll.index',
            compact('payrolls')
        );
    }
    public function slip($id)
{
    $payroll = Payroll::with([
        'employee.department'
    ])->findOrFail($id);


    $pdf = Pdf::loadView('payroll.slip', [
        'payroll' => $payroll
    ]);


    return $pdf->download(
        'salary-slip-'.$payroll->employee->employee_no.'.pdf'
    );
}
}