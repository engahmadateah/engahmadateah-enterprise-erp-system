<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'employee_id',
        'amount',
        'date',
        'notes'

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}