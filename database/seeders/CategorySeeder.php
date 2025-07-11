<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk memastikan data baru saja yang ada
        Category::query()->delete();

        $categories = [
            [
                'name' => 'Pakaian',
                'description' => 'Berbagai jenis pakaian seperti kaos, kemeja, dan hoodie.',
            ],
            [
                'name' => 'Lanyard',
                'description' => 'Lanyard custom untuk berbagai keperluan acara atau identitas.',
            ],
            [
                'name' => 'Totebag',
                'description' => 'Tas jinjing ramah lingkungan dengan berbagai desain.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
