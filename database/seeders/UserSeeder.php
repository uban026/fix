<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menonaktifkan foreign key check untuk mengizinkan truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Mengosongkan tabel users sebelum seeding
        User::truncate();

        // Mengaktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create('id_ID');

        // Create admin (sekarang tidak akan ada duplikat)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'address' => 'Jl. Admin No. 1, Jakarta',
            'phone' => '08123456789',
            'role' => 'admin',
        ]);

        // Create 10 users
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail, // Menggunakan safeEmail untuk menghindari domain yang tidak valid
                'password' => Hash::make('password'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'role' => 'user',
            ]);
        }
    }
}
