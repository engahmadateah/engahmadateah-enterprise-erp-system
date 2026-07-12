<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [

        'employee_id',

       'leave_type_id',

        'start_date',

        'end_date',

        'days',

        'reason',

        'status',

        'approved_by',

        'approved_at',

    ];

    public function employee()
    {
        return $this->belongsTo(
            Employee::class
        );
    }

    public function leaveType()
    {
        return $this->belongsTo(
            LeaveType::class
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
}