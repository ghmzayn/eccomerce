<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Store;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Pakaian', 'Elektronik/Handphone'];
        $category = fake()->randomElement($categories);

        $productNames = [
            'Pakaian' => [
                'Kemeja Katun Premium' => 'Terbuat dari 100% katun pilihan, kemeja ini menawarkan kenyamanan maksimal dan tampilan yang rapi. Cocok untuk acara formal maupun santai. Kualitas jahitan presisi menjamin ketahanan produk.',
                'Celana Chino Slim Fit' => 'Celana chino dengan potongan slim fit modern, terbuat dari bahan twill berkualitas tinggi yang elastis. Memberikan siluet ramping tanpa mengurangi kenyamanan bergerak. Pilihan tepat untuk gaya kasual semi-formal.',
                'Kaos Oblong Polos' => 'Kaos oblong polos bahan katun combed 30s yang adem dan lembut di kulit. Tersedia berbagai ukuran, cocok untuk sehari-hari. Jahitan rapi dan tidak mudah melar.',
                'Jaket Bomber Stylish' => 'Jaket bomber dengan desain modern dan bahan parasut berkualitas yang tahan angin. Dilengkapi dengan lapisan dalam yang nyaman dan ritsleting kuat. Ideal untuk melengkapi penampilan kasual Anda.',
                'Dress Midi Casual' => 'Dress midi casual berbahan rayon premium yang ringan dan jatuh. Desain longgar memberikan kenyamanan optimal dan cocok untuk berbagai bentuk tubuh. Mudah dipadupadankan dengan aksesoris favorit Anda.',
                'Hoodie Fleece Hangat' => 'Hoodie dengan bahan fleece tebal yang menghangatkan di musim hujan. Desain oversize dengan kantung kanguru praktis. Jahitan double-stitch memastikan ketahanan jangka panjang.',
            ],
            'Elektronik/Handphone' => [
                // ── Smartphones (RAM/Storage variants) ──
                'iPhone 17 Pro Max' => 'Smartphone flagship terbaru Apple dengan chip A19 Pro, layar Super Retina XDR 6.9 inci, dan kamera utama 48MP dengan kemampuan perekaman video 8K. Dilengkapi baterai tahan lama hingga 30 jam pemutaran video.',
                'Samsung Galaxy S25 Ultra' => 'Flagship Android dengan prosesor Snapdragon 8 Elite, layar Dynamic AMOLED 2X 120Hz, dan kamera 200MP dengan AI-enhanced photography. S-Pen terintegrasi untuk produktivitas maksimal.',
                'Google Pixel 10 Pro' => 'Smartphone dengan kamera AI terbaik di kelasnya, layar LTPO OLED 120Hz, dan Tensor G5 chip. Smooth experience dengan pure Android. Baterai 5000mAh dengan fast charging 45W.',
                'Xiaomi 15 Ultra' => 'Smartphone dengan kamera Leica optik 50MP, layar AMOLED 144Hz, dan pengisian daya hypercharge 120W. Snapdragon 8 Elite dengan sistem pendingin canggih untuk performa gaming tinggi.',
                // ── Keyboards (Color variants) ──
                'Keyboard Mechanical MX' => 'Keyboard mechanical 75% dengan switch Cherry MX yang responsif. Layout compact menghemat ruang meja. Dilengkapi backlight RGB dan keycap PBT double-shot premium. Tersedia dalam berbagai pilihan warna menarik.',
                'Keyboard Wireless Pro' => 'Keyboard wireless low-profile dengan koneksi Bluetooth 5.3 dan 2.4GHz. Baterai 4000mAh tahan hingga 6 bulan. Desain minimalis dengan tombol silent switch, cocok untuk kerja di kantor.',
                // ── Monitors (Size/model variants) ──
                'Monitor IPS 4K UHD' => 'Monitor profesional 27 inci resolusi 4K UHD dengan panel IPS 10-bit yang akurat. Mencakup 99% sRGB dan 95% DCI-P3. Cocok untuk desainer grafis, editor video, dan pekerjaan color-critical.',
                'Monitor Gaming 180Hz' => 'Monitor gaming 27 inci resolusi QHD 2560x1440 dengan refresh rate 180Hz super mulus. Panel Fast IPS dengan response time 1ms MPRT. Mendukung FreeSync Premium dan HDR400.',
            ],
        ];

        $productsForCategory = $productNames[$category];
        $productName = fake()->randomElement(array_keys($productsForCategory));
        $description = $productsForCategory[$productName];

        return [
            'store_id' => Store::factory(),
            'nama_produk' => $productName,
            'kategori' => $category,
            'deskripsi' => $description,
        ];
    }

    /**
     * Determine product type from name for variant logic
     */
    private function getProductType(string $nama_produk): string
    {
        $nama_produk = strtolower($nama_produk);

        if (str_contains($nama_produk, 'keyboard')) {
            return 'keyboard';
        }
        if (str_contains($nama_produk, 'monitor')) {
            return 'monitor';
        }
        if (str_contains($nama_produk, 'iphone') || str_contains($nama_produk, 'samsung') || str_contains($nama_produk, 'google') || str_contains($nama_produk, 'xiaomi')) {
            return 'smartphone';
        }
        return 'default';
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $type = $this->getProductType($product->nama_produk);

            if ($product->kategori === 'Pakaian') {
                // ── PAKAIAN: Size variants with progressive pricing ──
                $sizes = [
                    ['name' => 'S',  'price' => 75000],
                    ['name' => 'M',  'price' => 85000],
                    ['name' => 'L',  'price' => 95000],
                    ['name' => 'XL', 'price' => 110000],
                    ['name' => 'XXL','price' => 130000],
                ];
                shuffle($sizes);
                $selectedSizes = array_slice($sizes, 0, fake()->numberBetween(3, 5));

                foreach ($selectedSizes as $size) {
                    $price = $size['price'] + fake()->numberBetween(0, 9000);
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'nama_varian' => $size['name'],
                        'harga' => $price,
                        'stok' => fake()->numberBetween(15, 100),
                    ]);
                }
            } elseif ($type === 'smartphone') {
                // ── SMARTPHONE: RAM/Storage variants ──
                $variants = [
                    ['name' => '8GB/256GB',  'price' => 12000000],
                    ['name' => '12GB/256GB', 'price' => 14000000],
                    ['name' => '12GB/512GB', 'price' => 16500000],
                    ['name' => '16GB/512GB', 'price' => 19000000],
                    ['name' => '16GB/1TB',   'price' => 22000000],
                ];
                shuffle($variants);
                $selected = array_slice($variants, 0, fake()->numberBetween(3, 5));

                foreach ($selected as $v) {
                    $price = $v['price'] + fake()->numberBetween(0, 499000);
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'nama_varian' => $v['name'],
                        'harga' => $price,
                        'stok' => fake()->numberBetween(5, 30),
                    ]);
                }
            } elseif ($type === 'keyboard') {
                // ── KEYBOARD: Color variants ──
                $colors = [
                    ['name' => 'Hitam',  'price' => 450000],
                    ['name' => 'Putih',  'price' => 475000],
                    ['name' => 'Silver', 'price' => 500000],
                    ['name' => 'Merah',  'price' => 525000],
                    ['name' => 'Biru',   'price' => 550000],
                ];
                shuffle($colors);
                $selected = array_slice($colors, 0, fake()->numberBetween(3, 5));

                foreach ($selected as $c) {
                    $price = $c['price'] + fake()->numberBetween(0, 49000);
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'nama_varian' => $c['name'],
                        'harga' => $price,
                        'stok' => fake()->numberBetween(10, 40),
                    ]);
                }
            } elseif ($type === 'monitor') {
                // ── MONITOR: Size/resolution variants ──
                $models = [
                    ['name' => '24 inci FHD',   'price' => 2800000],
                    ['name' => '27 inci QHD',   'price' => 4200000],
                    ['name' => '27 inci 4K',    'price' => 5800000],
                    ['name' => '32 inci 4K',    'price' => 7800000],
                    ['name' => '34 inci Ultrawide', 'price' => 9500000],
                ];
                shuffle($models);
                $selected = array_slice($models, 0, fake()->numberBetween(3, 5));

                foreach ($selected as $m) {
                    $price = $m['price'] + fake()->numberBetween(0, 499000);
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'nama_varian' => $m['name'],
                        'harga' => $price,
                        'stok' => fake()->numberBetween(5, 25),
                    ]);
                }
            } else {
                // ── OTHER ELECTRONICS (Laptop, Smartwatch, Earbuds, Tablet, etc.): Classic RAM/Storage ──
                $combinations = [
                    ['name' => '128GB', 'price' => 2500000],
                    ['name' => '256GB', 'price' => 3500000],
                    ['name' => '512GB', 'price' => 5000000],
                    ['name' => '1TB',   'price' => 7000000],
                ];
                shuffle($combinations);
                $selected = array_slice($combinations, 0, fake()->numberBetween(3, 4));

                foreach ($selected as $combo) {
                    $price = $combo['price'] + fake()->numberBetween(0, 499000);
                    ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'nama_varian' => $combo['name'],
                        'harga' => $price,
                        'stok' => fake()->numberBetween(5, 30),
                    ]);
                }
            }
        });
    }
}
