<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [

        'ticket_number',
        'user_id',
        'title',
        'description',
        'teamviewer_id',
        'ip_address',
        'attachments',
        'status',
        

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [

        'attachments' => 'array'
    
    ];
}