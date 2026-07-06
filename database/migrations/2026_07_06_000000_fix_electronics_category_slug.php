<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')
            ->where('slug', 'elektronik-handphone')
            ->update(['slug' => 'elektronik', 'name' => 'Elektronik']);
    }

    public function down(): void
    {
        DB::table('categories')
            ->where('slug', 'elektronik')
            ->update(['slug' => 'elektronik-handphone', 'name' => 'Elektronik/Handphone']);
    }
};