<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = [

        'employee_id',
        'date',
        'hours',
        'hour_rate',
        'total_amount',
        'notes'

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}