<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [

        'code',

        'name',

        'type',

        'is_active'

    ];
    public function journalLines()
{
    return $this->hasMany(
        JournalEntryLine::class
    );
}
}