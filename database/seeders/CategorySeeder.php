<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Shirts', 'Cargo Pants', 'Shorts', 'Caps', 'Accessories', 'Footwear'];

        foreach ($categories as $category) {
            Category::create([
                'title' => $category,
                'description' => "This is a category for {$category}"
            ]);
        }
    }
}
