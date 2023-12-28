<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $title = [];
        $description = [];
        $product_image = [];
        $price = range(1000, 100000, 1000);
        $priceTake = fake()->randomElement($price);
        $salesPriceTake = round(rand(1000, $priceTake) / 100) * 100;
        $featured = fake()->boolean();
        $category_id = Category::inRandomOrder()->first()->id;
        $definition =  [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(8),
            'product_image' => 'https://api.lorem.space/image/album?w=300&h=400&random=' . Str::random(3),
            'price' => $priceTake,
            'sales_price' => fake()->randomElement($price),
            'featured' => $featured,
            'category_id' => $category_id

        ];

        return $definition;
    }
}
