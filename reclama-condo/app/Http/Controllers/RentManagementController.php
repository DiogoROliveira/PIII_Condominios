<?php

namespace App\Http\Controllers;

use App\Models\Condominium;
use App\Models\MonthlyPayment;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Payment;
use App\Services\GesApiService;
use App\Models\PaymentDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RentManagementController extends Controller
{
    public function index()
    {
        $condominiums = auth()->user()->condominiums;

        return view('admin.manage_payments.home', compact('condominiums'));
    }

    public function userIndex()
    {
        $tenants = Tenant::where('user_id', auth()->user()->id)->get();

        if (!$tenants) {
            return redirect()->route('user.dashboard')->with('error', 'No tenant found for the authenticated user.');
        }

        return view('user.rents.home', compact('tenants'));
    }

    public function userDetails($tenantId, GesApiService $service)
    {
        try {
            $service->authenticate();

            $paymentMethodsJson = $service->getPaymentMethods()['data'] ?? [];
        } catch (\Exception $e) {

            Log::error('Erro ao carregar os métodos de pagamento: ' . $e->getMessage());
            return redirect()->back()->withErrors('Erro ao carregar os métodos de pagamento.');
        }

        $tenant = Tenant::findOrFail($tenantId);
        $unit = Unit::where('tenant_id', $tenantId)->first();

        $paymentHistory = Payment::whereHas('monthly_payments', function ($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId);
        })->get();

        $pendingMonthlyPayments = MonthlyPayment::where('tenant_id', $tenantId)
            ->where('status', 'pending')
            ->whereDate('due_date', '>=', now())
            ->get();

        return view('user.rents.details', compact('tenant', 'paymentHistory', 'pendingMonthlyPayments', 'paymentMethodsJson', 'unit'));
    }

    public function pay(GesApiService $service, Request $request)
    {
        $request->validate([
            'monthly_payment_id' => 'exists:monthly_payments,id',
            'payment_method' => 'required|string',
            'name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:16',
            'card_expiration' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value)) {
                        $fail(__('O campo ') . $attribute . __(' deve estar no formato MM/YY com um mês válido.'));
                    }
                },
            ],
            'card_cvv' => 'nullable|string|max:3',
            'save_payment_details' => 'sometimes|boolean',
            'use_saved_payment' => 'sometimes|boolean',  // Verifica se o usuário quer usar o pagamento salvo
        ]);

        try {
            DB::beginTransaction();

            $monthlyPayment = MonthlyPayment::findOrFail($request->monthly_payment_id);

            if ($monthlyPayment->status !== 'pending') {
                return redirect()->back()->withErrors(__('Payment cannot be processed. The payment is already completed or overdue.'));
            }

            if ($request->has('use_saved_payment') && $request->use_saved_payment) {
                // Usar os detalhes do pagamento salvo
                $paymentDetails = PaymentDetails::where('tenant_id', $monthlyPayment->tenant_id)->latest()->first();
                if (!$paymentDetails) {
                    return redirect()->back()->withErrors(__('No saved payment method available.'));
                }
                // Adicionar o pagamento usando os dados salvos
                $payment = Payment::create([
                    'monthly_payment_id' => $monthlyPayment->id,
                    'amount' => $monthlyPayment->amount,
                    'paid_at' => now(),
                    'method' => $paymentDetails->method,
                ]);
            } else {
                // Salvar novo pagamento com dados fornecidos no formulário
                $payment = Payment::create([
                    'monthly_payment_id' => $monthlyPayment->id,
                    'amount' => $monthlyPayment->amount,
                    'paid_at' => now(),
                    'method' => $request->payment_method,
                ]);

                // Salvar os detalhes de pagamento se o usuário optou por isso
                if ($request->has('save_payment_details') && $request->save_payment_details) {
                    PaymentDetails::create([
                        'user_id' => $monthlyPayment->tenant->user_id,
                        'method' => $request->payment_method,
                        'name' => $request->name,
                        'card_number' => $request->card_number,
                        'card_expiration' => $request->card_expiration,
                    ]);
                }
            }

            // Atualizar status da mensalidade
            $monthlyPayment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', __('Payment processed successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(__('An error occurred while processing the payment.'));
        }
    }


    public function details($condominium)
    {
        $condominium = Condominium::with(['blocks.units'])->findOrFail($condominium);
        return view('admin.manage_payments.details', compact('condominium'));
    }

    public function storePayments(Request $request)
    {
        $unitIds = $request->input('units', []);
        $rents = $request->input('rents', []);
        $dueDate = $request->input('due_date');
        $condominiumId = $request->input('condominium_id');

        if (empty($unitIds) || empty($dueDate)) {
            return back()->with('error', __('Please select at least one unit and enter a due date.'));
        }

        DB::transaction(function () use ($unitIds, $rents, $dueDate) {
            foreach ($unitIds as $unitId) {
                $amount = $rents[$unitId] ?? 100;
                $unit = Unit::findOrFail($unitId);

                // Create monthly payment
                MonthlyPayment::create([
                    'unit_id' => $unitId,
                    'tenant_id' => $unit->tenant_id,
                    'amount' => $amount,
                    'status' => 'pending',
                    'due_date' => $dueDate,
                ]);

                // Update unit base rent
                $unit->update(['base_rent' => $amount]);
            }
        });

        return redirect()
            ->route('admin.manage-rents.blocks', ['condominium' => $condominiumId])
            ->with('success', __('Rent payments created successfully!'));
    }
}
