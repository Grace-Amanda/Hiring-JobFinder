<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'schedule_date' => fake()->dateTimeBetween('now', '+2 weeks')->format('Y-m-d'),
            'schedule_time' => fake()->time('H:i'), // Format jam dan menit (HH:MM)
            'location_or_link' => fake()->url(), // Menghasilkan link tautan virtual meeting
            'status' => fake()->randomElement(['scheduled', 'completed', 'cancelled', 'confirmed']),
        ];
    }
}