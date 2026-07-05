<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::with('store')->get();

        foreach ($products as $product) {
            $storeName = $product->store->name;
            $category = $product->kategori;
            $productId = $product->id;

            if ($category === 'Pakaian') {
                // Pakaian: Size variants (S, M, L, XL) with different prices
                $sizes = [
                    ['name' => 'S', 'price' => 89000, 'stock' => 20],
                    ['name' => 'M', 'price' => 95000, 'stock' => 30],
                    ['name' => 'L', 'price' => 102000, 'stock' => 30],
                    ['name' => 'XL', 'price' => 110000, 'stock' => 20],
                ];

                foreach ($sizes as $size) {
                    ProductVariant::create([
                        'product_id' => $productId,
                        'nama_varian' => $size['name'],
                        'harga' => $size['price'],
                        'stok' => $size['stock'],
                    ]);
                }
            } elseif ($category === 'Elektronik/Handphone') {
                // Elektronik: RAM/Storage variants with different prices
                $variants = [
                    ['name' => '4GB/64GB', 'price' => 1899000, 'stock' => 15],
                    ['name' => '6GB/128GB', 'price' => 2299000, 'stock' => 20],
                    ['name' => '8GB/256GB', 'price' => 2799000, 'stock' => 15],
                    ['name' => '12GB/256GB', 'price' => 3499000, 'stock' => 10],
                ];

                foreach ($variants as $variant) {
                    ProductVariant::create([
                        'product_id' => $productId,
                        'nama_varian' => $variant['name'],
                        'harga' => $variant['price'],
                        'stok' => $variant['stock'],
                    ]);
                }
            }
        }
    }
}