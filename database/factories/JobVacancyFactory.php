<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobVacancyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true), 
            'qualifications' => fake()->sentence(),
            'is_active' => fake()->boolean(85), 
        ];
    }
}