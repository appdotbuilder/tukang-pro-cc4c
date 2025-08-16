<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceRequest = ServiceRequest::where('status', 'completed')->inRandomOrder()->first();
        
        return [
            'service_request_id' => $serviceRequest ? $serviceRequest->id : ServiceRequest::factory(),
            'customer_id' => $serviceRequest ? $serviceRequest->customer_id : User::factory(['role' => 'customer']),
            'craftsman_id' => $serviceRequest ? $serviceRequest->craftsman_id : User::factory(['role' => 'craftsman']),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->paragraph(2),
        ];
    }
}