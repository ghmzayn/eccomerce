<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'status',
        'shipping_address', 'payment_method', 'payment_status',
        'payment_proof', 'paid_at', 'total_price', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
}
