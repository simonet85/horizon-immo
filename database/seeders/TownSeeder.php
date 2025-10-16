<?php

namespace Database\Seeders;

use App\Models\Town;
use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $towns = [
            [
                'name' => 'Le Cap',
                'slug' => 'le-cap',
                'description' => 'Capitale législative de l\'Afrique du Sud, célèbre pour la montagne de la Table et ses plages.',
                'is_active' => true,
            ],
            [
                'name' => 'Johannesburg',
                'slug' => 'johannesburg',
                'description' => 'Plus grande ville d\'Afrique du Sud et centre économique du pays.',
                'is_active' => true,
            ],
            [
                'name' => 'Durban',
                'slug' => 'durban',
                'description' => 'Ville portuaire sur la côte est, connue pour ses plages et son climat subtropical.',
                'is_active' => true,
            ],
            [
                'name' => 'Pretoria',
                'slug' => 'pretoria',
                'description' => 'Capitale administrative de l\'Afrique du Sud.',
                'is_active' => true,
            ],
            [
                'name' => 'Port Elizabeth',
                'slug' => 'port-elizabeth',
                'description' => 'Ville côtière du Cap oriental, connue pour ses plages et ses réserves naturelles.',
                'is_active' => true,
            ],
            [
                'name' => 'Bloemfontein',
                'slug' => 'bloemfontein',
                'description' => 'Capitale judiciaire de l\'Afrique du Sud.',
                'is_active' => true,
            ],
            [
                'name' => 'Polokwane',
                'slug' => 'polokwane',
                'description' => 'Capitale de la province du Limpopo.',
                'is_active' => true,
            ],
            [
                'name' => 'Hermanus',
                'slug' => 'hermanus',
                'description' => 'Ville côtière réputée pour l\'observation des baleines.',
                'is_active' => true,
            ],
        ];

        foreach ($towns as $town) {
            Town::create($town);
        }
    }
}
