<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use \App\Models\Concerns\Auditable;

    protected $fillable = [
        'customer_id',
        'product_id',

        'warehouse_id',

        'quantity',

        'unit_price',

        'total',

        'user_id',
        
        'invoice_number',
        'status',
        'cancelled_at',
        'cancelled_by',
        'cancel_reason',
    ];

    protected function casts(): array
    {
        return ['cancelled_at' => 'datetime'];
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
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