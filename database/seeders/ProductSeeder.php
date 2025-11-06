<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure categories exist
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $productsData = [
            [
                'category_slug' => 'nike-air-jordan',
                'name' => 'Air Jordan 1 Retro High OG "Chicago"',
                'slug' => 'air-jordan-1-retro-high-og-chicago',
                'sku' => 'AJ1-CHICAGO-001',
                'short_description' => 'Legendary Air Jordan 1 dengan kombinasi warna merah-putih ikonik.',
                'description' => 'Air Jordan 1 Retro High OG "Chicago" menghadirkan kembali desain klasik yang dikenakan Michael Jordan pada musim rookie. Material kulit premium dengan skema warna merah, putih, dan hitam memberikan look vintage yang tetap hype.',
                'price' => 2800000,
                'compare_at_price' => 3200000,
                'images' => [
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba',
                    'https://images.unsplash.com/photo-1523381210434-271e8be1f52b',
                ],
                'sizes' => [
                    ['size' => '40', 'stock' => 5],
                    ['size' => '41', 'stock' => 7],
                    ['size' => '42', 'stock' => 6],
                ],
            ],
            [
                'category_slug' => 'nike-air-max',
                'name' => 'Nike Air Max 90 "Infrared"',
                'slug' => 'nike-air-max-90-infrared',
                'sku' => 'AM90-INFRARED-001',
                'short_description' => 'Perpaduan retro dan modern dengan cushioning Air Max ikonik.',
                'description' => 'Nike Air Max 90 "Infrared" menampilkan kombinasi warna abu-abu, putih, dan aksen infrared cerah. Midsole empuk dengan unit Air terlihat memberikan kenyamanan maksimal untuk penggunaan harian.',
                'price' => 2200000,
                'compare_at_price' => 2500000,
                'images' => [
                    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77',
                    'https://images.unsplash.com/photo-1528701800489-20be3c2b1b45',
                ],
                'sizes' => [
                    ['size' => '39', 'stock' => 4],
                    ['size' => '40', 'stock' => 8],
                    ['size' => '41', 'stock' => 6],
                ],
            ],
            [
                'category_slug' => 'nike-dunk',
                'name' => 'Nike Dunk Low "Panda"',
                'slug' => 'nike-dunk-low-panda',
                'sku' => 'NDL-PANDA-001',
                'short_description' => 'Sneakers favorit dengan warna putih-hitam serbaguna.',
                'description' => 'Nike Dunk Low "Panda" menawarkan tampilan klasik dengan kombinasi warna hitam dan putih. Upper kulit dan siluet low membuatnya cocok dipakai sehari-hari maupun tampil street style.',
                'price' => 1900000,
                'compare_at_price' => 2100000,
                'images' => [
                    'https://images.unsplash.com/photo-1605348532760-6753d2c43329',
                    'https://images.unsplash.com/photo-1574689049330-43eec590c55c',
                ],
                'sizes' => [
                    ['size' => '38', 'stock' => 3],
                    ['size' => '39', 'stock' => 5],
                    ['size' => '40', 'stock' => 5],
                ],
            ],
            [
                'category_slug' => 'nike-running',
                'name' => 'Nike ZoomX Vaporfly NEXT% 2',
                'slug' => 'nike-zoomx-vaporfly-next-2',
                'sku' => 'NZV-NEXT2-001',
                'short_description' => 'Sepatu lari performa tinggi dengan foam ZoomX responsif.',
                'description' => 'Nike ZoomX Vaporfly NEXT% 2 dirancang untuk pelari yang ingin memecahkan waktu terbaiknya. Upper ringan, foam ZoomX yang responsif, dan plate carbon fiber memberikan dorongan maksimal.',
                'price' => 3500000,
                'compare_at_price' => 3800000,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                    'https://images.unsplash.com/photo-1575537302964-96cd47d0f37c',
                ],
                'sizes' => [
                    ['size' => '40', 'stock' => 4],
                    ['size' => '41', 'stock' => 5],
                    ['size' => '42', 'stock' => 5],
                ],
            ],
        ];

        foreach ($productsData as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();

            if (! $category) {
                continue;
            }

            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'brand' => 'Nike',
                    'sku' => $data['sku'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'compare_at_price' => $data['compare_at_price'],
                    'is_active' => true,
                ]
            );

            $product->images()->delete();
            foreach ($data['images'] as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $imageUrl,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }

            $product->sizes()->delete();
            foreach ($data['sizes'] as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size['size'],
                    'stock' => $size['stock'],
                    'price' => null,
                    'is_active' => true,
                ]);
            }
        }
    }
}
