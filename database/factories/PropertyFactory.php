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
        $types = ['villa', 'maison', 'appartement', 'terrain', 'commercial'];
        $cities = ['Cape Town', 'Johannesburg', 'Durban', 'Pretoria', 'Port Elizabeth', 'Stellenbosch', 'Franschhoek', 'Hermanus'];
        $statuses = ['available', 'reserved', 'sold'];
        
        $type = fake()->randomElement($types);
        $city = fake()->randomElement($cities);
        
        return [
            'title' => fake()->sentence(3) . ' à ' . $city,
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(500000, 5000000),
            'type' => $type,
            'city' => $city,
            'address' => fake()->address(),
            'bedrooms' => $type === 'terrain' ? null : fake()->numberBetween(1, 6),
            'bathrooms' => $type === 'terrain' ? null : fake()->numberBetween(1, 4),
            'surface_area' => fake()->numberBetween(50, 500),
            'status' => fake()->randomElement($statuses),
            'is_featured' => fake()->boolean(20), // 20% de chance d'être en vedette
            'images' => [
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&h=600&fit=crop',
                'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&h=600&fit=crop'
            ],
        ];
    }
}
