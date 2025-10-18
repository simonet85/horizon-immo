<?php

namespace Database\Factories;

use App\Models\Town;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Town>
 */
class TownFactory extends Factory
{
    protected $model = Town::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the town is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
