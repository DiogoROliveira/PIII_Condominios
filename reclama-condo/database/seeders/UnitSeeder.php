<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Block;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obter todos os blocos
        $blocks = Block::all();

        for ($i = 0; $i < 10; $i++) {

            $block = $blocks->random();
            $unit_number = $faker->numberBetween(1, $block->number_of_units);

            Unit::create([
                'block_id' => $block->id,
                'unit_number' => $unit_number,
                'status' => $faker->randomElement(['vacant', 'occupied', 'reserved', 'in repair']),
                'base_rent' => $faker->randomFloat(2, 300, 1500),
                'tenant_id' => rand(1, 10),
            ]);
        }
    }
}
