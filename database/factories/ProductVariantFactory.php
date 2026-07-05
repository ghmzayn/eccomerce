<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_varian' => fake()->word(), // Will be overridden by ProductFactory
            'harga' => fake()->randomFloat(2, 10000, 1000000), // Will be overridden by ProductFactory
            'stok' => fake()->numberBetween(1, 100),
        ];
    }
}
