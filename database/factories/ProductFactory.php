<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $name = $this->faker->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'brand' => 'Nike',
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->lexify('???'),
            'sku' => strtoupper($this->faker->unique()->bothify('SHOE-####')),
            'short_description' => $this->faker->sentence(12),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 300000, 1800000),
            'compare_at_price' => $this->faker->optional()->randomFloat(2, 350000, 2000000),
            'is_active' => true,
        ];
    }
}
