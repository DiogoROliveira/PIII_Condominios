<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Unit;
use App\Models\ComplaintType;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = User::all();
        $units = Unit::all();
        $complaintTypes = ComplaintType::all();

        if ($users->isEmpty() || $units->isEmpty() || $complaintTypes->isEmpty()) {
            $this->command->error('Certifique-se de que há usuários, unidades e tipos de reclamação na base de dados antes de executar este seeder.');
            return;
        }

        foreach (range(1, 50) as $index) {
            Complaint::create([
                'user_id' => $users->random()->id,
                'unit_id' => $units->random()->id,
                'complaint_type_id' => $complaintTypes->random()->id,
                'title' => "Título da Reclamação {$index}",
                'description' => "Descrição detalhada da Reclamação {$index}.",
                'status' => 'Pending',
                'response' => null,
            ]);
        }
    }
}
