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

        for($i = 1; $i <= 10; $i++){
            $room = Room::factory()->create([
                'owner_id' => $user->id,
                'room_number' => $i,
                'tenant' => fake()->name(),
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
