<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [

        'name',
        'code',
        'description',
        'is_active'

    ];
    public function employees()
{
    return $this->hasMany(
        Employee::class
    );
}
}