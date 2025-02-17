<?php

namespace App\Http\Controllers;
// Models
use App\Models\Condominium;
use App\Models\Invoice;
use App\Models\MonthlyPayment;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Payment;
use App\Models\PaymentDetails;
use App\Models\Block;

// Services
use App\Services\GesApiService;
use App\Notifications\MonthlyPaymentPhoneNotif;

// Helpers
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Exception;

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
            return redirect()->route('user.dashboard')->with('error', __('No tenant found for the authenticated user.'));
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
            return redirect()->back()->withErrors(__('Erro ao carregar os métodos de pagamento.'));
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

        $savedPaymentDetails = PaymentDetails::where('user_id', $tenant->user_id)->get();

        return view('user.rents.details', compact('tenant', 'paymentHistory', 'pendingMonthlyPayments', 'paymentMethodsJson', 'unit', 'savedPaymentDetails'));
    }

    public function pay(GesApiService $service, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'monthly_payment_id' => 'exists:monthly_payments,id',
            'payment_method' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:16',
            'card_expiration' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value)) {
                        $fail(__('The field ') . $attribute . __(' must be in MM/YY format with a valid month.'));
                    }
                },
            ],
            'card_cvv' => 'nullable|string|max:3',
        ]);

        $savePaymentDetails = $request->boolean('save_payment_details');
        $useSavedPayment = $request->boolean('use_saved_payment');


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }


        try {
            DB::beginTransaction();

            $monthlyPayment = MonthlyPayment::findOrFail($request->monthly_payment_id);

            if ($monthlyPayment->status !== 'pending') {
                return redirect()->back()->withErrors(__('Payment cannot be processed. The payment is already completed or overdue.'));
            }

            if ($useSavedPayment && $request->use_saved_payment) {
                $paymentDetails = PaymentDetails::where('user_id', $monthlyPayment->tenant->user_id)->latest()->first();
                if (!$paymentDetails) {
                    return redirect()->back()->withErrors(__('No saved payment method available.'));
                }

                $payment = Payment::create([
                    'monthly_payment_id' => $monthlyPayment->id,
                    'amount' => $monthlyPayment->amount,
                    'paid_at' => now(),
                    'method' => $paymentDetails->method,
                ]);
            } else {

                $needsBank = collect($request->paymentMethodsJson)->firstWhere('code', $request->payment_method)['needsBank'] ?? false;

                if ($needsBank) {
                    $request->validate([
                        'name' => 'required|string|max:255',
                        'card_number' => 'required|string|max:16',
                        'card_expiration' => 'required|string|max:5',
                        'card_cvv' => 'required|string|max:3',
                    ]);
                }

                // Create payment
                $payment = Payment::create([
                    'monthly_payment_id' => $monthlyPayment->id,
                    'amount' => $monthlyPayment->amount,
                    'paid_at' => now(),
                    'method' => $request->payment_method,
                ]);

                // Save payment details
                if ($savePaymentDetails && $request->save_payment_details) {
                    PaymentDetails::create([
                        'user_id' => $monthlyPayment->tenant->user_id,
                        'method' => $request->payment_method,
                        'name' => $request->name,
                        'card_number' => $request->card_number,
                        'card_expiration' => $request->card_expiration,
                        'card_cvv' => $request->card_cvv,
                    ]);
                }
            }

            // Update payment status
            $monthlyPayment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            DB::commit();

            try {
                $tenant = Tenant::where('user_id', $monthlyPayment->tenant->user_id)->first();
                $user = $tenant->user;

                $unit = Unit::where('id', $monthlyPayment->unit_id)->first();
                $block = Block::where('id', $unit->block_id)->first();
                $condo = Condominium::where('id', $block->condominium_id)->first();

                $service->authenticate();

                $clientData = $service->getClientData()['data'];
            } catch (Exception $e) {
                throw new \Exception('Client data not found.');
                return redirect()->back()->withErrors([__('Error getting client data to send invoice.')]);
            }

            try {

                $emailExists = collect($clientData)->contains('email', Crypt::decrypt($user->email));

                $service->authenticate();
                if (!$emailExists) {
                    $service->postClientData($user, $condo);
                }
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([__('An error occurred while creating the client.')]);
            }


            try {
                $service->authenticate();
                $clientId = collect($clientData)->firstWhere('email', Crypt::decrypt($user->email))['id'];
                $invoice = $service->postInvoiceData($monthlyPayment, $payment, $clientId);

                if (!$invoice || $invoice['errors'] === true) {
                    throw new \Exception('Invoice creation failed: ' . ($invoice['result']['message'] ?? 'Unknown error'));
                }

                Invoice::create([
                    'invoice' => $invoice['fatura'],
                    'reference' => $invoice['referencia'],
                    'payment_id' => $payment->id,
                    'tenant_id' => $monthlyPayment->tenant_id,
                ]);
            } catch (Exception $e) {
                Log::error('Invoice creation error: ' . $e->getMessage());
                return redirect()->back()->withErrors([__('Error creating invoice: ') . $e->getMessage()]);
            }

            try {

                $invoiceData = Invoice::where('reference', $invoice['referencia'])->first();
                $service->authenticate();
                $service->sendInvoiceMail($invoiceData, $user);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([__('An error occurred while sending the invoice email.')]);
            }

            MonthlyPaymentPhoneNotif::paymentCompleted($user);
            return redirect()->back()->with('success', __('Payment processed successfully. Invoice sent to account email.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
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

                // Notify via SMS the tenant
                MonthlyPaymentPhoneNotif::paymentCreated($unit->tenant->user);

                // Update unit base rent
                $unit->update(['base_rent' => $amount]);
            }
        });

        return redirect()
            ->route('admin.manage-rents.blocks', ['condominium' => $condominiumId])
            ->with('success', __('Rent payments created successfully!'));
    }
}
