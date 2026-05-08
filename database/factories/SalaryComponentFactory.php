<?php

namespace Database\Factories;

use App\Models\SalaryComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SalaryComponent>
 */
class SalaryComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('CMP-###')),
            'name' => fake()->word(),
            'type' => fake()->randomElement(['earning', 'deduction']),
            'is_fixed' => fake()->boolean(70),
            'default_amount' => fake()->numberBetween(50000, 1000000),
            'is_active' => true,
        ];
    }
}
