<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data produk lama untuk memastikan data yang di-seed adalah data baru
        Product::query()->delete();

        // Ambil ID kategori yang relevan. Pastikan CategorySeeder sudah dijalankan.
        $pakaianCategory = Category::where('name', 'Pakaian')->first();
        $lanyardCategory = Category::where('name', 'Lanyard')->first();
        $totebagCategory = Category::where('name', 'Totebag')->first();

        // Jika kategori tidak ditemukan, hentikan seeder untuk menghindari error.
        if (!$pakaianCategory || !$lanyardCategory) {
            $this->command->error('Pastikan kategori Pakaian dan Lanyard sudah ada sebelum menjalankan ProductSeeder.');
            return;
        }

        $products = [
            // =============== Kategori Pakaian ===============
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Anime',
                'description' => 'Kaos eksklusif dengan desain karakter anime populer. Bahan adem dan nyaman.',
                'price' => '125000.00',
                'stock' => 80,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'assets/img/kaos_anime.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Yoasobi',
                'description' => 'Tunjukkan dukunganmu untuk Yoasobi dengan kaos berkualitas ini.',
                'price' => '130000.00',
                'stock' => 65,
                'sizes' => ['M', 'L', 'XL'],
                'image' => 'assets/img/portofolio/kaos_yoasobi.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Squid Game',
                'description' => 'Kaos ikonik dari serial drama populer Squid Game.',
                'price' => '110000.00',
                'stock' => 90,
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'image' => 'assets/img/portofolio/kaos_squid_game.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Reg Aespa Armageddon',
                'description' => 'Kaos edisi spesial untuk comeback Aespa "Armageddon".',
                'price' => '150000.00',
                'stock' => 50,
                'sizes' => ['S', 'M', 'L'],
                'image' => 'assets/img/portofolio/Kaos_reg_aespa_armageddon.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Jennie',
                'description' => 'Kaos stylish yang terinspirasi dari fashion Jennie BLACKPINK.',
                'price' => '145000.00',
                'stock' => 70,
                'sizes' => ['S', 'M', 'L'],
                'image' => 'assets/img/portofolio/kaos_jennie.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Baby Monster',
                'description' => 'Kaos debut dari girl group baru, Baby Monster.',
                'price' => '140000.00',
                'stock' => 75,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'image' => 'assets/img/portofolio/kaos_baby_monster.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Crop Top Black Pink',
                'description' => 'Crop top trendy dengan logo Black Pink, cocok untuk konser atau hangout.',
                'price' => '160000.00',
                'stock' => 60,
                'sizes' => ['S', 'M', 'L'],
                'image' => 'assets/img/portofolio/crop_top_black_pink.jpg',
            ],
            [
                'category_id' => $pakaianCategory->id,
                'name' => 'Kaos Kaki KDrama 1988',
                'description' => 'Kaos kaki lucu dengan tema drama Korea Reply 1988.',
                'price' => '55000.00',
                'stock' => 100,
                'sizes' => ['All Size'],
                'image' => 'assets/img/portofolio/kaos_kaki_kdrama_1988.jpg',
            ],

            // =============== Kategori Lanyard ===============
            [
                'category_id' => $lanyardCategory->id,
                'name' => 'Lanyard NCT',
                'description' => 'Lanyard keren dengan logo NCT, wajib punya untuk NCTzen.',
                'price' => '45000.00',
                'stock' => 150,
                'sizes' => null,
                'image' => 'assets/img/portofolio/lanyard_nct.jpg',
            ],
            [
                'category_id' => $lanyardCategory->id,
                'name' => 'Lanyard NCT Dream',
                'description' => 'Lanyard eksklusif NCT Dream untuk menemani aktivitasmu.',
                'price' => '45000.00',
                'stock' => 130,
                'sizes' => null,
                'image' => 'assets/img/portofolio/lanyard_nct_dream.jpg',
            ],
            [
                'category_id' => $lanyardCategory->id,
                'name' => 'Lanyard Enhypen',
                'description' => 'Tunjukkan dukungan untuk Enhypen dengan lanyard resmi ini.',
                'price' => '40000.00',
                'stock' => 120,
                'sizes' => null,
                'image' => 'assets/img/portofolio/Lanyard_ENHYPEN.jpg',
            ],
            [
                'category_id' => $lanyardCategory->id,
                'name' => 'Lanyard BTS',
                'description' => 'Lanyard premium untuk para ARMY, bahan berkualitas dan cetakan tajam.',
                'price' => '50000.00',
                'stock' => 200,
                'sizes' => null,
                'image' => 'assets/img/portofolio/lanyard_bts.jpg',
            ],
        ];

        // Buat produk di database
        foreach ($products as $productData) {
            Product::create([
                'category_id' => $productData['category_id'],
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'sizes' => $productData['sizes'],
                'image' => $productData['image'], // Menggunakan path gambar dari aset
                'is_active' => true,
            ]);
        }
    }
}
