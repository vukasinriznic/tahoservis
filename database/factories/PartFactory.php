<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => fake()->word(),
            'supplier' => fake()->word(),
            'quantity' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
