<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',

        'warehouse_id',

        'quantity',

        'unit_price',

        'total',

        'user_id',
        
        'invoice_number',
    ];

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

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
    public function customer()
{
    return $this->belongsTo(
        Customer::class
    );
}
}