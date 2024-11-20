<?php

namespace Database\Seeders;

use App\Models\Condominium;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CondominiumSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = \App\Models\User::where('role_id', 1)->get();


        if ($users->isEmpty()) {
            $this->command->error('Não existem usuários na tabela para associar aos condomínios.');
            return;
        }


        for ($i = 0; $i < 5; $i++) {
            Condominium::create([
                'name' => $faker->company,
                'address' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->state,
                'postal_code' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'admin_id' => $users->random()->id,
                'number_of_blocks' => rand(1, 5),
            ]);
        }
    }
}
