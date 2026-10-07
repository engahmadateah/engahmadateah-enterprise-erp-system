<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\StockMovement;

class Product extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'name',

        'sku',

        'quantity',

        'purchase_price',

        'sale_price',

        'is_active',

        'category_id',

        'warehouse_id',

        'low_stock',
    
    ];
    public function category()
{
    return $this->belongsTo(
        Category::class
    );
}
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