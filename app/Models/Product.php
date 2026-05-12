<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'promo_price', 'stock', 'image', 'is_promo',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'promo_price' => 'decimal:2',
            'is_promo' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->is_promo && $this->promo_price ? $this->promo_price : $this->price;
    }
}
