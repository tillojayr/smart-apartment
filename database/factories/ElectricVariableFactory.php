<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ElectricVariable>
 */
class ElectricVariableFactory extends Factory
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
            'room_id' => Room::factory()->create(),
            'bill' => fake()->numberBetween(0, 2000),
            'volts' => fake()->numberBetween(210, 240),
            'current' => fake()->numberBetween(1, 10)
        ];
    }
}
