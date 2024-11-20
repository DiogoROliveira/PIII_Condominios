<?php

namespace App\Http\Controllers;

use App\Models\MonthlyPayment;
use App\Models\Unit;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;

class MonthlyPaymentController extends Controller
{
    public function adminIndex(Request $request)
    {
        $monPayments = MonthlyPayment::all();
        return view('admin.monthly_payments.home', compact('monPayments'));
    }

    public function create(Request $request)
    {
        $units = Unit::all();
        $tenants = Tenant::select('id', 'user_id')->get();
        $users = User::all();
        return view('admin.monthly_payments.create', compact('units', 'tenants', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'due_date' => 'required|date|after_or_equal:today',
            'amount' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'status' => 'required|in:pending,paid,overdue',
            'paid_at' => 'nullable|date',
        ]);

        $tenant = Unit::findOrFail($request->unit_id)->tenant;

        if (!$tenant) {
            return redirect()->route('admin.monthly-payments.create')
                ->with('error', __('Tenant not found for the selected unit.'));
        }

        MonthlyPayment::create([
            'unit_id' => $request->unit_id,
            'tenant_id' => $tenant->id,
            'due_date' => $request->due_date,
            'amount' => $request->amount,
            'status' => $request->status,
            'paid_at' => $request->paid_at,
        ]);

        return redirect()->route('admin.monthly-payments')
            ->with('success', __('Monthly Payment created successfully!'));
    }


    public function edit($id)
    {
        $monthlyPayment = MonthlyPayment::findOrFail($id);
        return view('admin.monthly_payments.edit', compact('monthlyPayment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,overdue',
            'amount' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'due_date' => 'required|date|after_or_equal:today',
            'paid_at' => 'nullable|date|after_or_equal:created_at',
        ]);

        $monthlyPayment = MonthlyPayment::findOrFail($id);
        $monthlyPayment->update($request->only(['status', 'amount', 'due_date', 'paid_at']));

        return redirect()->route('admin.monthly-payments')
            ->with('success', __('Monthly Payment updated successfully.'));
    }

    public function destroy($id)
    {
        $monthlyPayment = MonthlyPayment::findOrFail($id);
        $monthlyPayment->delete();
        return redirect()->route('admin.monthly-payments')
            ->with('success', __('Monthly Payment deleted successfully.'));
    }
}
