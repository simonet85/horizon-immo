<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Villa', 'Maison', 'Appartement', 'Terrain', 'Commercial'];
        $transactionTypes = ['Vente', 'Location'];
        $statuses = ['available', 'reserved', 'sold'];
        $locations = ['Cape Town', 'Johannesburg', 'Durban', 'Pretoria', 'Port Elizabeth', 'Stellenbosch', 'Franschhoek', 'Hermanus'];

        $type = fake()->randomElement($types);

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(500000, 5000000),
            'type' => $type,
            'transaction_type' => fake()->randomElement($transactionTypes),
            'city' => fake()->randomElement($locations),
            'address' => fake()->address(),
            'surface_area' => fake()->numberBetween(50, 500),
            'bedrooms' => $type === 'Terrain' ? null : fake()->numberBetween(1, 6),
            'bathrooms' => $type === 'Terrain' ? null : fake()->numberBetween(1, 4),
            'status' => fake()->randomElement($statuses),
            'category_id' => \App\Models\Category::factory(),
            'images' => [
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&h=600&fit=crop',
            ],
        ];
    }
}
