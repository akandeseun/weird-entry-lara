<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Blue', 'Black', 'Red', 'Green', 'Yellow', 'Orange', 'White'];

        foreach ($colors as $color) {
            Color::create([
                'title' => $color,
                'description' => "This is a color for {$color}"
            ]);
        }
    }
}
