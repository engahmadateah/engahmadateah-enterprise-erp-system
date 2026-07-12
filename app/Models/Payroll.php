<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [

        'employee_id',
        'month',
        'year',

        'basic_salary',

        'attendance_salary',

        'overtime_amount',

        'bonus_amount',

        'advance_deduction',

        'loan_deduction',

        'net_salary'

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}