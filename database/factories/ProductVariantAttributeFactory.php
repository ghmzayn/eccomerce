<?php

namespace Database\Factories;

use App\Models\ProductVariantAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductVariantAttribute>
 */
class ProductVariantAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'product_variant_id' will be set when creating
            'attribute_key' => fake()->word(),
            'attribute_value' => fake()->word(),
        ];
    }
}
