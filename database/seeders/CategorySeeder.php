<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'description' => 'Propriétés de luxe avec jardin et plusieurs chambres',
                'is_active' => true,
            ],
            [
                'name' => 'Maison',
                'slug' => 'maison',
                'description' => 'Maisons individuelles familiales',
                'is_active' => true,
            ],
            [
                'name' => 'Appartement',
                'slug' => 'appartement',
                'description' => 'Appartements en résidence ou immeuble',
                'is_active' => true,
            ],
            [
                'name' => 'Terrain',
                'slug' => 'terrain',
                'description' => 'Terrains à bâtir ou terrains agricoles',
                'is_active' => true,
            ],
            [
                'name' => 'Commercial',
                'slug' => 'commercial',
                'description' => 'Locaux commerciaux, bureaux, entrepôts',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
