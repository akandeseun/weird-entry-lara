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
        $categoryIds = Category::take(20)->pluck('id')->all();
        // $sizeIds = Size::take(20)->pluck('id')->all();
        // $colorIds = Color::take(20)->pluck('id')->all();
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(8),
            'product_image' => 'https://api.lorem.space/image/album?w=300&h=400&random=' . Str::random(3),
            'price' => fake()->randomNumber(5, true),
            'sales_price' => fake()->optional()->randomNumber(5, true),
            'featured' => fake()->boolean(),
            'category_id' => Arr::random($categoryIds)

        ];
    }
}
