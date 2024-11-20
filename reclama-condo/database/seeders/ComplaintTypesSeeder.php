<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('complaint_types')->insert([
            ['name' => 'Noise Complaints'],
            ['name' => 'Cleaning Problems'],
            ['name' => 'Maintenance Issues'],
            ['name' => 'Security Concerns'],
            ['name' => 'Parking Issues'],
            ['name' => 'Property Damage'],
            ['name' => 'General Inquiries'],
            ['name' => 'Other'],
        ]);
    }
}
