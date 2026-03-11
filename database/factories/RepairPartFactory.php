<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\Repair;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairPartFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'repair_id' => Repair::factory(),
            'part_id' => Part::factory(),
            'quantity_used' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
