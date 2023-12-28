<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['Small', 'Medium', 'Large', 'X-Large', 'XX-Large', 'XXX-Large'];

        foreach ($sizes as $size) {
            Size::create([
                'title' => $size,
                'description' => "This is a size for {$size}"
            ]);
        }
    }
}
