<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceRequest>
 */
class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'accepted', 'in_progress', 'completed', 'cancelled']);
        $customer = User::where('role', 'customer')->inRandomOrder()->first();
        $craftsman = $status !== 'pending' ? User::where('role', 'craftsman')->inRandomOrder()->first() : null;
        
        return [
            'customer_id' => $customer ? $customer->id : User::factory(['role' => 'customer']),
            'craftsman_id' => $craftsman ? $craftsman->id : null,
            'skill_id' => Skill::inRandomOrder()->first() ? Skill::inRandomOrder()->first()->id : Skill::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'location' => fake()->address(),
            'estimated_budget' => fake()->randomFloat(2, 100, 2000),
            'preferred_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => $status,
            'final_amount' => $status === 'completed' ? fake()->randomFloat(2, 100, 2000) : null,
            'started_at' => in_array($status, ['in_progress', 'completed']) ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'photos' => null,
        ];
    }
}