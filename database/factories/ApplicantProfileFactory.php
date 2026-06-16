<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => 'active_searching',
            'full_name' => fake()->name(),
            'date_of_birth' => fake()->date(),
            'location_applicant' => fake()->city(), 
            'education' => 'S1 Informatika',
            'rating' => fake()->randomFloat(2, 3, 5),
            'job_history' => fake()->paragraph(),
            'document_ktp' => 'dummy_ktp_' . fake()->uuid() . '.pdf',
            'document_ijazah' => 'dummy_ijazah_' . fake()->uuid() . '.pdf',
            'document_cv' => 'dummy_cv_' . fake()->uuid() . '.pdf',
        ];
    }
}