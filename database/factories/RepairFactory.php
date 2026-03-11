<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'service_request_id' => ServiceRequest::factory(),
            'work_done' => fake()->text(),
            'seal_number' => fake()->word(),
            'pdf_path' => fake()->word(),
        ];
    }
}
