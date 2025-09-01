<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Villa Moderne Le Cap',
                'description' => 'Magnifique villa moderne avec vue panoramique sur Table Mountain et l\'océan Atlantique. Cette propriété exceptionnelle offre des finitions haut de gamme, une piscine infinity et un jardin paysager.',
                'price' => 2850000,
                'location' => 'Camps Bay, Le Cap',
                'type' => 'Villa',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'surface_area' => 350,
                'images' => ['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2075&q=80'],
                'featured' => true
            ],
            [
                'title' => 'Appartement Vista Marina',
                'description' => 'Appartement de luxe avec vue imprenable sur le port de plaisance V&A Waterfront. Résidence sécurisée avec concierge, gymnase et terrasse commune avec piscine.',
                'price' => 1920000,
                'location' => 'V&A Waterfront, Le Cap',
                'type' => 'Appartement',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'surface_area' => 120,
                'images' => ['https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'],
                'featured' => true
            ],
            [
                'title' => 'Maison Familiale Stellenbosch',
                'description' => 'Charmante maison familiale située au cœur des vignobles de Stellenbosch. Architecture Cape Dutch authentique avec piscine, garage double et dépendance.',
                'price' => 3200000,
                'location' => 'Stellenbosch',
                'type' => 'Maison familiale',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'surface_area' => 450,
                'images' => ['https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2053&q=80'],
                'featured' => true
            ],
            [
                'title' => 'Penthouse Sandton City',
                'description' => 'Penthouse de prestige dans le quartier financier de Sandton. Vue à 360° sur Johannesburg, terrasse privée, 3 places de parking et accès aux services hôteliers.',
                'price' => 4500000,
                'location' => 'Sandton, Johannesburg',
                'type' => 'Penthouse',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'surface_area' => 250,
                'images' => ['https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?ixlib=rb-4.0.3&auto=format&fit=crop&w=2532&q=80'],
                'featured' => false
            ],
            [
                'title' => 'Villa Hermanus Oceanfront',
                'description' => 'Villa exceptionnelle en front de mer à Hermanus, célèbre pour l\'observation des baleines. Design contemporain, accès direct à la plage privée.',
                'price' => 5200000,
                'location' => 'Hermanus',
                'type' => 'Villa',
                'bedrooms' => 6,
                'bathrooms' => 5,
                'surface_area' => 600,
                'images' => ['https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80'],
                'featured' => false
            ],
            [
                'title' => 'Appartement Green Point',
                'description' => 'Appartement moderne dans le quartier branché de Green Point, à proximité du stade et du front de mer. Idéal pour investissement locatif.',
                'price' => 1650000,
                'location' => 'Green Point, Le Cap',
                'type' => 'Appartement',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'surface_area' => 85,
                'images' => ['https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'],
                'featured' => false
            ],
            [
                'title' => 'Maison Constantia Winelands',
                'description' => 'Propriété familiale dans les prestigieux vignobles de Constantia. Architecture traditionnelle, grand jardin et cave à vin.',
                'price' => 3800000,
                'location' => 'Constantia, Le Cap',
                'type' => 'Maison familiale',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'surface_area' => 380,
                'images' => ['https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80'],
                'featured' => false
            ],
            [
                'title' => 'Villa Camps Bay Sunset',
                'description' => 'Villa d\'architecte avec vue coucher de soleil sur l\'océan Atlantique. Design minimaliste, piscine à débordement et garage pour 4 voitures.',
                'price' => 6200000,
                'location' => 'Camps Bay, Le Cap',
                'type' => 'Villa',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'surface_area' => 520,
                'images' => ['https://images.unsplash.com/photo-1600607687644-aac4c3eac7f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2112&q=80'],
                'featured' => false
            ]
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}
