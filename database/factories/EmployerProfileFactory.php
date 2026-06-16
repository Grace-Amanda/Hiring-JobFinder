<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployerProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => 'active', // Tetap ikuti kemauan database
            'company_name' => fake()->company(),
            'location_employer' => fake()->city(), 
            'company_type' => 'Technology',
            'rating' => fake()->randomFloat(2, 3, 5),
            'reviews' => fake()->paragraph(),
            'document_npwp' => 'dummy_npwp_' . fake()->uuid() . '.pdf',
            'document_nib' => 'dummy_nib_' . fake()->uuid() . '.pdf',
        ];
    }
}