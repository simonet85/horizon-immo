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
        // Créer un utilisateur administrateur
        \App\Models\User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@horizonimmo.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        // Créer quelques propriétés d'exemple
        \App\Models\Property::factory(5)->create();
    }
}
