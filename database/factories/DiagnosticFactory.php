<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiagnosticFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'service_request_id' => ServiceRequest::factory(),
            'problem_description' => fake()->text(),
            'diagnostic_results' => fake()->text(),
            'recommended_work' => fake()->text(),
        ];
    }
}
