<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'division_id' => null,
            'position_id' => null,
            'nik' => fake()->unique()->numerify('EMP######'),
            'name' => fake()->name(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'join_date' => fake()->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d'),
            'status' => 'active',
            'base_salary' => fake()->numberBetween(4000000, 12000000),
        ];
    }
}
