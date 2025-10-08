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

        // Créer quelques catégories supplémentaires si nécessaire
        if (\App\Models\Category::count() < 5) {
            $newCategories = \App\Models\Category::factory(3)->create();
        }

        // Récupérer toutes les catégories
        $categories = \App\Models\Category::all();

        // Créer quelques propriétés d'exemple avec des catégories
        \App\Models\Property::factory(10)->create([
            'category_id' => $categories->random()->id,
        ]);
    }
}
