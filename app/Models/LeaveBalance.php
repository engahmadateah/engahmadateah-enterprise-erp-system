<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [

        'employee_id',

        'annual_balance',

        'used_balance',

        'remaining_balance',

    ];

    public function employee()
    {
        return $this->belongsTo(
            Employee::class
        );
    }
}