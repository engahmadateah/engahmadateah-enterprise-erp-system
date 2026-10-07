<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'employee_id',
        'amount',
        'monthly_installment',
        'remaining_balance',
        'start_date',
        'notes',
        'is_closed'

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}