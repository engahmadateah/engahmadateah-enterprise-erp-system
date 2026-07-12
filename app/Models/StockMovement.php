<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\User;
class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'type',
        'quantity',
        'note',
        'user_id',
    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}
public function warehouse()
{
    return $this->belongsTo(Warehouse::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
