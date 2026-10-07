<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [

        'supplier_id',
        'product_id',
        'warehouse_id',
        'quantity',
        'unit_price',
        'total',
        'purchase_date',
        'notes',

    ];

    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }

    public function warehouse()
    {
        return $this->belongsTo(
            Warehouse::class
        );
    }
}