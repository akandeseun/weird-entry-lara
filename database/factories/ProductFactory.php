<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


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
            'https://i.pinimg.com/564x/99/b5/76/99b576c531fba6cd73145b2ff549b649.jpg',
            'https://i.pinimg.com/474x/52/a1/78/52a17874b6bc2b6bd6c843867ae7780a.jpg',
            'https://i.pinimg.com/474x/99/d2/e1/99d2e16034c2e30d5d2d51ae6f014201.jpg',
            'https://i.pinimg.com/474x/d2/64/e8/d264e8f78ef4fdf150e536bf3c518dcb.jpg',
            'https://i.pinimg.com/474x/86/49/10/864910b80879b333c0f9e53626b4e373.jpg',
            'https://i.pinimg.com/474x/f1/54/bd/f154bd2a5ab84086e29ae1460eaa5a19.jpg',
            'https://i.pinimg.com/474x/89/ed/f8/89edf882e43e515b50e88eff45c63837.jpg',
            'https://i.pinimg.com/564x/bc/02/0a/bc020a155835e3a2efeb78aeac4c1f99.jpg',
            'https://i.pinimg.com/474x/7a/4e/ae/7a4eaeff7d22f824f34fcce685cc287a.jpg',
            'https://i.pinimg.com/474x/26/a1/a7/26a1a768da1a664427a16465ea742d8b.jpg',
            'https://i.pinimg.com/474x/bd/d4/68/bdd468d9cc0991771e4f734294547273.jpg',
            'https://i.pinimg.com/474x/ce/cb/28/cecb281a2a4128a446b7e29105b1d9a2.jpg',
            'https://i.pinimg.com/474x/1d/35/57/1d35572ef26a34321398971318070c6d.jpg',
            'https://i.pinimg.com/474x/66/f2/37/66f237683ba24dad6d41fd59f7ea51cd.jpg',
            'https://i.pinimg.com/474x/6c/75/60/6c756015bb74a8940866916558d32344.jpg'

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
