<?php

namespace Database\Seeders;

use App\Models\MonthlyPayment;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MonthlyPaymentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $units = Unit::all();

        if ($units->isEmpty()) {
            $this->command->error('Não existem unidades na tabela para associar os pagamentos mensais.');
            return;
        }

        // A variável que controlará se já existe um 'paid'
        $paidStatusSet = false;

        for ($i = 0; $i < 10; $i++) {

            $due_date = $faker->date();
            $paid_at = $faker->optional()->dateTimeBetween($due_date, '+1 month'); // Pode ser null

            // Atribuição inicial do status
            $status = 'pending'; // Valor default se `paid_at` for null

            // Se o pagamento foi feito
            if ($paid_at) {
                $paid_at = $paid_at->format('Y-m-d H:i:s');

                // Se o pagamento foi feito depois da data de vencimento
                if ($paid_at > $due_date) {
                    $status = 'overdue';
                }

                // Se o pagamento foi feito antes ou na data de vencimento
                else {
                    $status = 'paid';
                }
            }

            // Se o pagamento não foi feito
            else {
                $paid_at = null;
            }

            // Se ainda não houver pagamento 'paid', garantimos que o primeiro que aparecer será pago
            if (!$paidStatusSet && $status !== 'overdue') {
                $status = 'paid';
                $paid_at = $due_date; // Definir o pagamento no mesmo dia da data de vencimento
                $paidStatusSet = true; // Marcar como 'paid' foi atribuído
            }

            MonthlyPayment::create([
                'unit_id' => $units->random()->id,
                'tenant_id' => rand(1, 10),
                'due_date' => $due_date,
                'amount' => $faker->randomFloat(2, 300, 1500),
                'status' => $status,
                'paid_at' => $paid_at,
            ]);
        }
    }
}
