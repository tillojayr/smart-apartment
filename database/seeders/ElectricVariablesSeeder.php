<?php

namespace Database\Seeders;

use App\Models\ElectricVariable;
use Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectricVariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = now();
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 2; $j++) {
            ElectricVariable::factory()->create([
                'owner_id' => 1,
                'room_id' => $i,
                'volts' => rand(200, 250),
                'current' => rand(10, 20),
                'consumed' => rand(100, 200),
                'created_at' => $timestamp,
            ]);
            $timestamp->addSeconds($j);
            }
        }
    }
}
