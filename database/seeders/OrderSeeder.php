<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Hapus semua data pesanan yang ada untuk memastikan awal yang bersih.
     * Saat ini tidak ada data pesanan baru yang dibuat.
     */
    public function run(): void
    {
        // Menonaktifkan pemeriksaan foreign key untuk proses truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Menghapus semua data dari tabel order_items dan orders
        OrderItem::truncate();
        Order::truncate();

        // Mengaktifkan kembali pemeriksaan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Anda bisa menambahkan logika untuk membuat data pesanan baru di sini di kemudian hari.
        // Contoh:
        // $users = User::all();
        // $products = Product::all();
        //
        // foreach ($users as $user) {
        //     // Logika pembuatan order...
        // }
    }
}
