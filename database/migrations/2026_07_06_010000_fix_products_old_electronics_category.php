<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update produk yang masih pakai nama kategori lama
        DB::table('products')
            ->where('kategori', 'Elektronik/Handphone')
            ->update(['kategori' => 'Elektronik']);
    }

    public function down(): void
    {
        DB::table('products')
            ->where('kategori', 'Elektronik')
            ->update(['kategori' => 'Elektronik/Handphone']);
    }
};
