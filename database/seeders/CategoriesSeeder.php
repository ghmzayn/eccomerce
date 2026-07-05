<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
            'description' => 'Koleksi pakaian pria dan wanita berkualitas dengan berbagai ukuran dan model terbaru',
        ]);

        Category::create([
            'name' => 'Elektronik/Handphone',
            'slug' => 'elektronik-handphone',
            'description' => 'Smartphone, laptop, tablet, aksesoris gadget, dan perangkat elektronik lainnya',
        ]);
    }
}
