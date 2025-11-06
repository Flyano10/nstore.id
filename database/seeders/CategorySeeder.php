<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Nike Air Jordan',
                'slug' => 'nike-air-jordan',
                'description' => 'Koleksi klasik Air Jordan dengan warna dan kolaborasi terbaru.',
            ],
            [
                'name' => 'Nike Air Max',
                'slug' => 'nike-air-max',
                'description' => 'Sneakers Air Max dengan tampilan kasual dan kenyamanan maksimal.',
            ],
            [
                'name' => 'Nike Dunk',
                'slug' => 'nike-dunk',
                'description' => 'Variasi Nike Dunk low dan high dengan palet warna kekinian.',
            ],
            [
                'name' => 'Nike Running',
                'slug' => 'nike-running',
                'description' => 'Sepatu lari Nike ringan dengan teknologi terbaru.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
