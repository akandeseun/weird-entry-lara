<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(8),
            'product_image' => fake()->url(),
            'price' => fake()->randomNumber(5, true),
            'sales_price' => fake()->optional()->randomNumber(5, true),
            'featured' => fake()->boolean(),
            // 'category_id'

        ];
    }
}
