<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()->create([
            'name' => 'Butik Anggun',
            'address' => 'Jl. Melati Raya No. 12, Jakarta Selatan 12130',
            'contact' => '0812-3456-7890',
        ]);

        Store::factory()->create([
            'name' => 'Gadget Impian',
            'address' => 'Ruko Sentra Niaga Blok B No. 5, Surabaya 60231',
            'contact' => '0878-1234-5678',
        ]);

        Store::factory()->create([
            'name' => 'Fashion Kekinian',
            'address' => 'Jl. Diponegoro No. 25, Bandung 40115',
            'contact' => '0852-9876-5432',
        ]);
    }
}