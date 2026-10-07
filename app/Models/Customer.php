<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'name',

        'phone',

        'email',

        'address',

        'is_active',

    ];

    public function sales()
{
    return $this->hasMany(
        Sale::class
    );
}
}