<?php

namespace Database\Seeders;

use App\Models\Control;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test Apartment',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Hash the password
        ]);

        for ($i = 1; $i <= 4; $i++) {
            $room = Room::factory()->create([
                'owner_id' => $user->id,
                'room_number' => $i,
                'tenant' => fake()->name(),
                'contact_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
                'address' => fake()->address(),
                'reminder_time' => fake()->numberBetween(1000, 9999),
                'joined_at' => now(),
                'password' => Str::random(10),
            ]);

            Control::factory()->create([
                'owner_id' => $user->id,
                'room_id' => $room->id,
            ]);
        }
    }
}
