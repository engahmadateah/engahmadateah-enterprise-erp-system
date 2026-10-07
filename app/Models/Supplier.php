<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'name',
        'phone',
        'email',
        'address',
        'is_active',

    ];
    public function purchases()
{
    return $this->hasMany(
        Purchase::class
    );
}
}