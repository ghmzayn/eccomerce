<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat user admin & customer
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 1, Jakarta Pusat',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'customer@toko.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '085678901234',
            'address' => 'Jl. Kenanga No. 10, Bandung',
        ]);

        // 2. Toko, produk, varian, dan siaran
        $this->call([
            StoreSeeder::class,
            CategoriesSeeder::class,
            ProductSeeder::class,
            // ProductVariantSeeder tidak dipanggil karena
            // ProductFactory::configure() sudah auto-create varian via afterCreating
            BroadcastSeeder::class,
        ]);
    }
}