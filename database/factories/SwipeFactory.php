<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SwipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Menyesuaikan status swipe yang umum digunakan
            'status' => fake()->randomElement(['pending', 'matched', 'rejected']),
        ];
    }
}