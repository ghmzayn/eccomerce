<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom category_id (nullable dulu)
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('store_id');
        });

        // 2. Migrasi data — cocokin kategori string ke categories.name (kompatibel SQLite & MySQL)
        DB::statement('UPDATE products SET category_id = (SELECT id FROM categories WHERE categories.name = products.kategori)');

        // 3. Hapus kolom kategori
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });

        // 4. Set NOT NULL & tambah FK
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Tambah kolom kategori string
        Schema::table('products', function (Blueprint $table) {
            $table->string('kategori', 100)->after('store_id');
        });

        // Balikin data dari relasi (kompatibel SQLite & MySQL)
        DB::statement('UPDATE products SET kategori = (SELECT name FROM categories WHERE categories.id = products.category_id)');

        // Drop category_id
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
