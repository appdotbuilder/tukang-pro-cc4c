<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Basic Certification', 'Intermediate Certification', 
                'Advanced Certification', 'Expert Certification'
            ]),
            'description' => fake()->sentence(8),
            'level' => fake()->randomElement(['basic', 'intermediate', 'advanced', 'expert']),
            'rate_multiplier' => fake()->randomFloat(2, 1.0, 2.5),
            'is_active' => true,
        ];
    }
}