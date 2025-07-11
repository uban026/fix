<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN INI

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan foreign key check untuk mengizinkan truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Mengosongkan tabel coupons sebelum seeding
        Coupon::truncate();

        // Mengaktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // Kupon default untuk pesanan tanpa diskon
        Coupon::create([
            'name' => '-',
            'status' => 'active',
            'type' => 'amount',
            'value' => 0
        ]);

        // Kupon diskon 10%
        Coupon::create([
            'name' => 'DISKON10',
            'status' => 'active',
            'type' => 'percent',
            'value' => 10
        ]);

        // Kupon potongan Rp 5.000
        Coupon::create([
            'name' => 'HEMAT5000',
            'status' => 'active',
            'type' => 'amount',
            'value' => 5000
        ]);
    }
}
