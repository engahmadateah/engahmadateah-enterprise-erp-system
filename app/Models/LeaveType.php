<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [

        'name',

        'is_deducted',
        

    ];

    public function leaves()
    {
        return $this->hasMany(
            Leave::class
        );
    }
}