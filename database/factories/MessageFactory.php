<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message' => fake()->sentence(),
            'is_read' => fake()->boolean(40), 
        ];
    }
}