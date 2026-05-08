<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('POS-###')),
            'name' => fake()->jobTitle(),
            'level' => fake()->numberBetween(1, 5),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
