<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory()->create(),
            'room_number' => fake()->numberBetween(1, 10),
            'tenant' => fake()->words(2, true),
            'joined_at' => now(),
            'password' => Str::random(10),
            'bill' => fake()->numberBetween(1000, 2000),
            'volts' => fake()->numberBetween(210, 240),
            'current' => fake()->numberBetween(1, 20),
            'consumed' => fake()->numberBetween(1, 10000),
            'token' => Str::random(20),
        ];
    }
}
