<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Qios',
            'email' => 'admin@copi.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Kopi No.1, Jakarta',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@copi.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '087654321098',
            'address' => 'Jl. Mawar No.5, Bandung',
        ]);

        $elektronik = Category::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
            'description' => 'Gadget, perangkat elektronik, dan aksesoris tech',
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Pakaian, sepatu, tas, dan perlengkapan fashion',
        ]);

        $aksesoris = Category::create([
            'name' => 'Aksesoris',
            'slug' => 'aksesoris',
            'description' => 'Aksesoris unik dan menarik untuk gaya hidup',
        ]);

        Product::create([
            'category_id' => $elektronik->id,
            'name' => 'Earphone Wireless BT-500',
            'slug' => 'earphone-wireless-bt-500',
            'description' => 'Earphone bluetooth dengan bass kuat, baterai 8 jam',
            'price' => 299000,
            'stock' => 50,
            'is_promo' => true,
            'promo_price' => 229000,
        ]);

        Product::create([
            'category_id' => $elektronik->id,
            'name' => 'Power Bank 20000 mAh',
            'slug' => 'power-bank-20000-mah',
            'description' => 'Power bank fast charging dual USB, slim & ringan',
            'price' => 189000,
            'stock' => 30,
        ]);

        Product::create([
            'category_id' => $fashion->id,
            'name' => 'Kaos Polos Premium Cotton',
            'slug' => 'kaos-polos-premium-cotton',
            'description' => 'Kaos bahan cotton combed 30s, adem dan nyaman dipakai',
            'price' => 85000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => $fashion->id,
            'name' => 'Topi Snapback Distro',
            'slug' => 'topi-snapback-distro',
            'description' => 'Topi snapback adjustable, bahan kanvas berkualitas',
            'price' => 75000,
            'stock' => 60,
            'is_promo' => true,
            'promo_price' => 55000,
        ]);

        Product::create([
            'category_id' => $aksesoris->id,
            'name' => 'Dompet Kulit Pria Slim',
            'slug' => 'dompet-kulit-pria-slim',
            'description' => 'Dompet tipis bahan kulit sintetik, muat banyak kartu',
            'price' => 120000,
            'stock' => 40,
        ]);

        Product::create([
            'category_id' => $aksesoris->id,
            'name' => 'Gelang Tali Paracord',
            'slug' => 'gelang-tali-paracord',
            'description' => 'Gelang tali paracord handmade, kuat dan stylish',
            'price' => 35000,
            'stock' => 80,
            'is_promo' => true,
            'promo_price' => 25000,
        ]);
    }
}
