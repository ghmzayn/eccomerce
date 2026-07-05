<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            if ($store->name === 'Butik Anggun' || $store->name === 'Fashion Kekinian') {
                // Pakaian products - 4 produk per toko pakaian
                Product::factory()->for($store)->create(['kategori' => 'Pakaian']);
                Product::factory()->for($store)->create(['kategori' => 'Pakaian']);
                Product::factory()->for($store)->create(['kategori' => 'Pakaian']);
                Product::factory()->for($store)->create(['kategori' => 'Pakaian']);
            } elseif ($store->name === 'Gadget Impian') {
                // Elektronik/Handphone products - 4 produk per toko elektronik
                // Elektronik/Handphone products - 4 produk per toko elektronik
                Product::factory()->for($store)->create(['kategori' => 'Elektronik/Handphone']);
                Product::factory()->for($store)->create(['kategori' => 'Elektronik/Handphone']);
                Product::factory()->for($store)->create(['kategori' => 'Elektronik/Handphone']);
                Product::factory()->for($store)->create(['kategori' => 'Elektronik/Handphone']);
            }
        }
    }
}