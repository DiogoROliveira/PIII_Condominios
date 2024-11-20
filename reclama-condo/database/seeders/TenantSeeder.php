<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {

            $leaseStartDate = $faker->date();
            $leaseEndDate = $faker->dateTimeBetween($leaseStartDate, '+6 years')->format('Y-m-d');

            Tenant::create([
                'user_id' => rand(1, 10),
                'lease_start_date' => $leaseStartDate,
                'lease_end_date' => $leaseEndDate,
                'status' => $faker->randomElement(['active', 'inactive']),
                'notes' => $faker->text(100),
            ]);
        }
    }
}
