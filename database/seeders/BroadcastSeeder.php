<?php

namespace Database\Seeders;

use App\Models\Broadcast;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class BroadcastSeeder extends Seeder
{
    public function run(): void
    {
        $storeId = fn(string $name) => Store::where('name', $name)->value('id');
        $productId = fn(string $name) => Product::where('nama_produk', $name)->value('id');

        // Siaran dari Butik Anggun (toko pakaian)
        Broadcast::create([
            'store_id' => $storeId('Butik Anggun'),
            'title' => 'Butik Anggun — Diskon Akhir Pekan Kemeja & Dress',
            'description' => 'Dapatkan diskon hingga 25% untuk kemeja katun premium dan dress midi casual. Koleksi terbatas, cocok untuk gaya santai maupun formal. Promo berlaku setiap akhir pekan!',
            'product_id' => $productId('Kemeja Katun Premium'),
            'is_live' => true,
        ]);

        // Siaran dari Gadget Impian (toko elektronik)
        Broadcast::create([
            'store_id' => $storeId('Gadget Impian'),
            'title' => 'Gadget Impian — iPhone 17 Pro Max Sudah Tersedia!',
            'description' => 'iPhone 17 Pro Max dengan chip A19 Pro dan kamera 48MP sudah bisa dipesan. Tersedia varian 256GB hingga 1TB. Gratis AppleCare+ untuk 100 pembeli pertama!',
            'product_id' => $productId('iPhone 17 Pro Max'),
            'is_live' => true,
        ]);

        // Siaran dari Fashion Kekinian (toko pakaian)
        Broadcast::create([
            'store_id' => $storeId('Fashion Kekinian'),
            'title' => 'Fashion Kekinian — Jaket Bomber & Hoodie Baru!',
            'description' => 'Koleksi jaket bomber stylish dan hoodie fleece hangat terbaru sudah tersedia. Bahan premium, desain kekinian, cocok untuk musim hujan. Cek sekarang sebelum kehabisan!',
            'product_id' => $productId('Jaket Bomber Stylish'),
            'is_live' => true,
        ]);

        // Siaran non-live (arsip)
        Broadcast::create([
            'store_id' => $storeId('Gadget Impian'),
            'title' => 'Rekomendasi Keyboard Mechanical untuk Gaming & Ngetik',
            'description' => 'Keyboard Mechanical MX dengan switch Cherry MX tersedia dalam 5 pilihan warna. Cocok untuk gaming dan mengetik. Review lengkap dan perbandingan tipe di blog kami!',
            'product_id' => $productId('Keyboard Mechanical MX'),
            'is_live' => false,
        ]);
    }
}
