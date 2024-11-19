<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Services\GesApiService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function index(GesApiService $service)
    {
        $payments = Payment::all();
        $paymentMethodsJson = [];

        try {
            $service->authenticate();
            $methods = $service->getPaymentMethods()['data'] ?? [];
            $paymentMethodsJson = collect($methods)->keyBy('id');
        } catch (\Exception $e) {
            Log::error('Erro ao carregar os métodos de pagamento: ' . $e->getMessage());
        }

        return view('admin.payments.home', compact('payments', 'paymentMethodsJson'));
    }

    public function create(GesApiService $service)
    {
        try {
            $service->authenticate();

            $paymentMethodsJson = $service->getPaymentMethods()['data'] ?? [];

            $monthlyPayments = MonthlyPayment::all();

            return view('admin.payments.create', compact('monthlyPayments', 'paymentMethodsJson'));
        } catch (\Exception $e) {
            Log::error('Erro ao criar pagamento: ' . $e->getMessage());
            return redirect()->back()->withErrors('Erro ao carregar os métodos de pagamento.');
        }
    }

    public function store(Request $request, GesApiService $service)
    {
        $request->validate([
            'monthly_payment_id' => 'required|exists:monthly_payments,id',
            'amount' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'paid_at' => 'nullable|date',
            'method' => 'required',
        ]);

        $monthlyPayment = MonthlyPayment::findOrFail($request->monthly_payment_id);

        if ($monthlyPayment->status === 'paid') {
            return redirect()->back()->withErrors(['error' => __('This monthly payment has already been paid.')]);
        }

        if ($monthlyPayment->status === 'overdue') {
            return redirect()->back()->withErrors(['error' => __('This monthly payment is overdue. Contact the condo admin to extend the payment deadline.')]);
        }

        if ($request->amount > $monthlyPayment->amount) {
            return redirect()->back()->withErrors(['error' => __('The amount must be less than or equal to the monthly payment amount.')]);
        }

        $paidAt = $request->paid_at ? $request->paid_at : now();

        $monthlyPayment->update([
            'status' => 'paid',
            'paid_at' => $paidAt,
        ]);

        Payment::create([
            'monthly_payment_id' => $monthlyPayment->id,
            'amount' => $request->amount,
            'paid_at' => $paidAt,
            'method' => $request->method,
        ]);

        return redirect()->route('admin.payments')->with('success', __('Payment created successfully.'));
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return redirect()->route('admin.payments')->with('success', __('Payment deleted successfully.'));
    }
}
