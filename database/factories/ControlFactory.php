<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Control>
 */
class ControlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'owner_id' => User::factory()->create(),
            // 'room_id' => Room::factory()->create(),
            'relay_1' => 0,
            'relay_2' => 0
        ];
    }
}
