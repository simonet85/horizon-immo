<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // D'abord créer les rôles et permissions
        $this->call(RolePermissionSeeder::class);

        // Créer les catégories de propriétés
        $this->call(CategorySeeder::class);

        // Créer un utilisateur administrateur ou le récupérer s'il existe déjà
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@horizonimmo.com'],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle admin
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Créer un utilisateur client ou le récupérer s'il existe déjà
        $client = \App\Models\User::firstOrCreate(
            ['email' => 'client@horizonimmo.com'],
            [
                'name' => 'Client Test',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assigner le rôle client
        if (! $client->hasRole('client')) {
            $client->assignRole('client');
        }

        // Récupérer toutes les catégories
        $categories = \App\Models\Category::all();

        // Créer quelques propriétés d'exemple manuellement (sans factory pour éviter le problème Faker)
        if (\App\Models\Property::count() === 0) {
            $properties = [
                [
                    'title' => 'Villa luxueuse avec piscine - Douala',
                    'description' => 'Magnifique villa moderne située dans un quartier calme de Douala. Elle dispose de 4 chambres spacieuses, 3 salles de bain, un grand salon avec vue panoramique, une cuisine équipée et une piscine extérieure.',
                    'price' => 450000000, // 450 millions FCFA
                    'currency' => 'FCFA',
                    'transaction_type' => 'Vente',
                    'city' => 'Cape Town',
                    'address' => '123 Avenue de la Liberté, Bonanjo, Douala',
                    'bedrooms' => 4,
                    'bathrooms' => 3,
                    'surface_area' => 350,
                    'status' => 'available',
                    'is_featured' => true,
                    'category_id' => $categories->where('slug', 'villa')->first()->id,
                    'images' => ['https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&h=600&fit=crop'],
                ],
                [
                    'title' => 'Appartement moderne centre-ville - Yaoundé',
                    'description' => 'Bel appartement rénové au cœur de Yaoundé. 2 chambres, 2 salles de bain, balcon avec vue sur la ville, parking sécurisé.',
                    'price' => 85000000, // 85 millions FCFA
                    'currency' => 'FCFA',
                    'transaction_type' => 'Vente',
                    'city' => 'Johannesburg',
                    'address' => '45 Boulevard du 20 Mai, Bastos, Yaoundé',
                    'bedrooms' => 2,
                    'bathrooms' => 2,
                    'surface_area' => 95,
                    'status' => 'available',
                    'is_featured' => false,
                    'category_id' => $categories->where('slug', 'appartement')->first()->id,
                    'images' => ['https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&h=600&fit=crop'],
                ],
                [
                    'title' => 'Maison familiale 3 chambres - Kribi',
                    'description' => 'Charmante maison familiale proche des plages. Jardin arboré, garage double, 3 chambres, 2 salles de bain.',
                    'price' => 120000000, // 120 millions FCFA
                    'currency' => 'FCFA',
                    'transaction_type' => 'Vente',
                    'city' => 'Durban',
                    'address' => '78 Route de la Plage, Kribi',
                    'bedrooms' => 3,
                    'bathrooms' => 2,
                    'surface_area' => 180,
                    'status' => 'available',
                    'is_featured' => true,
                    'category_id' => $categories->where('slug', 'maison')->first()->id,
                    'images' => ['https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&h=600&fit=crop'],
                ],
            ];

            foreach ($properties as $property) {
                \App\Models\Property::create($property);
            }
        }
    }
}
