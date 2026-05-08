<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $workDate = Carbon::today()->subDays(fake()->numberBetween(1, 25));
        $checkIn = (clone $workDate)->setTime(8, fake()->numberBetween(0, 30));
        $checkOut = (clone $workDate)->setTime(17, fake()->numberBetween(0, 30));
        $scheduledStart = (clone $workDate)->setTime(8, 0);

        return [
            'employee_id' => Employee::factory(),
            'work_date' => $workDate->toDateString(),
            'check_in_at' => $checkIn,
            'check_out_at' => $checkOut,
            'status' => 'present',
            'late_minutes' => max(0, $scheduledStart->diffInMinutes($checkIn, false)),
            'notes' => null,
        ];
    }
}
