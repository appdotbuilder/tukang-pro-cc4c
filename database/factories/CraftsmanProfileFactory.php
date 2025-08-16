<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CraftsmanProfile>
 */
class CraftsmanProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => fake()->paragraph(3),
            'years_experience' => fake()->numberBetween(1, 25),
            'hourly_rate' => fake()->randomFloat(2, 50, 200),
            'location' => fake()->city(),
            'rating' => fake()->randomFloat(2, 3.0, 5.0),
            'total_reviews' => fake()->numberBetween(0, 100),
            'work_areas' => [fake()->city(), fake()->city(), fake()->city()],
            'profile_photo' => null,
            'is_available' => fake()->boolean(80),
            'is_verified' => fake()->boolean(70),
            'insurance_rate' => fake()->randomFloat(2, 2.0, 8.0),
        ];
    }
}