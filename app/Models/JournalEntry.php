<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [

        'entry_number',

        'entry_date',

        'description',

        'user_id'

    ];

    public function lines()
    {
        return $this->hasMany(
            JournalEntryLine::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}