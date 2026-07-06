<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'category_id', 'nama_produk', 'deskripsi', 'image'];

    protected $appends = ['effective_price'];

    /**
     * Use route key name for URL resolution (products/{product:id})
     * Laravel defaults to 'id' which works fine
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the lowest variant price as effective price
     */
    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->productVariants()->min('harga') ?? 0);
    }

    /**
     * Get total stock across all variants
     */
    public function getTotalStockAttribute(): int
    {
        return (int) ($this->productVariants()->sum('stok') ?? 0);
    }

    /**
     * Check if product has any variant in stock
     */
    public function getInStockAttribute(): bool
    {
        return $this->productVariants()->where('stok', '>', 0)->exists();
    }

    /**
     * Scope: products by same category (for related products)
     */
    public function scopeSameCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
