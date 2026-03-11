<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'serviser_id' => User::factory(),
            'tachograph_type' => fake()->randomElement(["analogni","digitalni"]),
            'description' => fake()->text(),
            'desired_date' => fake()->dateTime(),
            'phone' => fake()->phoneNumber(),
            'status' => fake()->randomElement(["zakazano","u_dijagnostici","u_popravci","zavrseno"]),
        ];
    }
}
