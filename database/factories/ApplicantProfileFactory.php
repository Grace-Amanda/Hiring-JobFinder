<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['active', 'inactive']),
            'full_name' => fake()->name(),
            'date_of_birth' => fake()->date('Y-m-d', '2005-01-01'),
            'location' => fake()->city(), // Tambahan kolom location
            'education' => fake()->randomElement(['SMA', 'D3', 'S1', 'S2']),
            'rating' => fake()->randomFloat(2, 1, 5),
            'job_history' => fake()->paragraph(),
            'document_ktp' => 'dummy_ktp_' . fake()->uuid() . '.pdf',
            'document_ijazah' => 'dummy_ijazah_' . fake()->uuid() . '.pdf', // Tambahan ijazah
            'document_cv' => 'dummy_cv_' . fake()->uuid() . '.pdf',
        ];
    }
}