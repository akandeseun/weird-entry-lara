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

    public function attachRelationships(Product $product)
    {
        $sizes = Size::inRandomOrder()->take(3)->pluck('id');
        $colors = Color::inRandomOrder()->take(3)->pluck('id');
        $product->sizes()->attach($sizes);
        $product->colors()->attach($colors);

        $product->save();
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'CITYSCAPE SHIRT',
            'NEOSTREET SHIRT',
            'TECHNOIR SHIRT',
            'STREETSAVVY SHIRT',
            'EDGEWALK SHIRT',
            'URBAN GEAR CARGO TROUSERS',
            'UTILITY CARGO JOGGERS',
            'REBEL CARGO BOTTOMS',
            'EDGEWALK CARGO PANTS',
            'METRO EDGE BEANIE',
            'STREET FUSION BUCKET HAT',
            'UTILITY SNAPBACK',
            'HI-TECH FIVE-PANEL CAP',
            'STEALTH TRUCKER HAT',
            'URBANITE HIGH TOPS',
            'TECH STREET SNEAKERS',
            'CITYSCAPE RUNNERS',
            'GRAFFITI PRINT TRAINERS'
        ];
        $description = fake()->sentence(8);
        $product_image = [
            'https://unsplash.com/photos/man-in-blue-and-white-crew-neck-t-shirt-and-blue-fitted-cap-standing-on-sidewalk-ebTNU_YTWgc',
            'https://pixabay.com/photos/woman-beauty-fashion-streetwear-7508618/',
            'https://pixabay.com/photos/girl-model-portrait-female-woman-5688122/',
            'https://unsplash.com/photos/man-in-white-crew-neck-t-shirt-TysFvOl78u0',
            'https://unsplash.com/photos/mens-white-crew-neck-t-shirt-2XcbGfYShfk',
            'https://unsplash.com/photos/woman-in-white-crew-neck-t-shirt-FTrGeAy0RW4',
            'https://unsplash.com/photos/woman-in-white-crew-neck-t-shirt-standing-beside-brown-concrete-wall-aP8KhiHbSvo',
            'https://www.canva.com/photos/MAEQU2IZ5dU-a-man-in-brown-shirt-standing/',
            'https://www.canva.com/photos/MAEuCjn6llE-a-man-wearing-a-kimono-jacket-and-a-bonnet-on-a-roof/',
            'https://www.canva.com/photos/MAETIQRzMnQ-high-angle-shot-of-a-man-with-a-black-bucket-hat/',
            'https://www.canva.com/photos/MADyR_pPu30-photo-of-two-standing-men-posing-beside-wooden-wall/',
            'https://www.canva.com/photos/MAEPSFinXSs-sports-shoes-against-white-background/',
            'https://www.canva.com/photos/MAEVlz2K3Qk-white-and-blue-rubber-shoes/',
            'https://www.canva.com/photos/MAEPIscFDyg-black-and-purple-nike-athletic-shoe/',
            'https://www.canva.com/photos/MAEPkgDkb4M/',
            'https://www.canva.com/photos/MAETVFgGsww-woman-in-white-shirt-and-beige-cargo-pants/'

        ];
        $price = range(1000, 100000, 1000);
        $priceTake = fake()->randomElement($price);
        $salesPriceTake = round(rand(1000, $priceTake) / 100) * 100;
        $featured = fake()->boolean();
        $category_id = Category::inRandomOrder()->first()->id;
        $definition =  [
            'title' => "WEIRD ENTRY " . fake()->randomElement($titles),
            'description' => $description,
            'product_image' => fake()->randomElement($product_image),
            'price' => $priceTake,
            'sales_price' => fake()->randomElement([null, $salesPriceTake]),
            'featured' => $featured,
            'category_id' => $category_id

        ];

        return $definition;
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $this->attachRelationships($product);
        });
    }
}
