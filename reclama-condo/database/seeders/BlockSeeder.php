<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Block::create([
                'block' => $faker->word,
                'condominium_id' => rand(1, 5),
                'number_of_units' => rand(5, 20),
            ]);
        }
    }
}
