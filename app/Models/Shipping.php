<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'order_id', 'courier', 'service', 'shipping_cost', 'status', 'tracking_number',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}