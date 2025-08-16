<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Plumbing', 'Electrical', 'Carpentry', 'Painting', 'Masonry',
                'Roofing', 'Welding', 'HVAC', 'Flooring', 'Tiling'
            ]),
            'description' => fake()->sentence(10),
            'base_rate' => fake()->randomFloat(2, 50, 150),
            'is_active' => true,
        ];
    }
}