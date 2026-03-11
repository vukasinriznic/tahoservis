<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->word(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(["klijent","serviser","administrator"]),
            'softDeletes' => fake()->word(),
        ];
    }
}
