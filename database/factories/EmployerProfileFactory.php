<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployerProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['active', 'inactive']),
            'company_name' => fake()->company(),
            'location' => fake()->city(),
            'company_type' => fake()->randomElement(['Technology', 'Finance', 'Healthcare', 'Creative']),
            'rating' => fake()->randomFloat(2, 1, 5), 
            'reviews' => fake()->paragraph(),
            'document_npwp' => 'dummy_npwp_' . fake()->uuid() . '.pdf',
            'document_nib' => 'dummy_nib_' . fake()->uuid() . '.pdf',
        ];
    }
}