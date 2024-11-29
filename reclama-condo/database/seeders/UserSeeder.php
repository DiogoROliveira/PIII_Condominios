<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => Crypt::encrypt($faker->email),
                'phone' => $faker->phoneNumber,
                'password' => bcrypt('password'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
