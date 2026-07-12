<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [

        'employee_no',

         'user_id',

        'department_id',

        'first_name',

        'last_name',

        'email',

        'phone',

        'position',

        'salary',

        'join_date',

        'avatar',

        'is_active',

        'annual_leave_balance',

        'used_leave_days',

    ];

    public function department()
    {
        return $this->belongsTo(
            Department::class
        );
    }
    public function attendances()
{
    return $this->hasMany(Attendance::class);
}
public function payrolls()
{
    return $this->hasMany(
        Payroll::class
    );
}
public function overtimes()
{
    return $this->hasMany(Overtime::class);
}

public function bonuses()
{
    return $this->hasMany(Bonus::class);
}

public function advances()
{
    return $this->hasMany(Advance::class);
}

public function loans()
{
    return $this->hasMany(Loan::class);
}
public function leaveBalance()
{
    return $this->hasOne(
        LeaveBalance::class
    );
}

public function leaves()
{
    return $this->hasMany(
        Leave::class
    );
}
public function user()
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}

}