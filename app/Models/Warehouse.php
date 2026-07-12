<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];
    public function warehouse()
{
    return $this->belongsTo(Warehouse::class);
}
public function purchases()
{
    return $this->hasMany(
        Purchase::class
    );
}
}
