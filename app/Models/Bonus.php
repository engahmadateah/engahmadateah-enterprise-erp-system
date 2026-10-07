<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [
        'employee_id',
        'amount',
        'date',
        'reason'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}