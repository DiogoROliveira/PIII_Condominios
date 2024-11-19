<?php

namespace App\Http\Controllers;

use App\Models\Condominium;
use App\Models\MonthlyPayment;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RentManagementController extends Controller
{
    public function index()
    {
        $condominiums = auth()->user()->condominiums;

        return view('admin.manage_payments.home', compact('condominiums'));
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

        if (empty($unitIds) || empty($dueDate)) {
            return back()->with('error', __('Please select at least one unit and enter a due date.'));
        }

        DB::transaction(function () use ($unitIds, $rents, $dueDate) {
            foreach ($unitIds as $unitId) {
                $amount = $rents[$unitId] ?? 100;
                MonthlyPayment::create([
                    'unit_id' => $unitId,
                    'tenant_id' => Tenant::where('unit_id', $unitId)->value('id'),
                    'amount' => $amount,
                    'status' => 'pending',
                    'due_date' => $dueDate,
                ]);

                Unit::where('id', $unitId)->update(['base_rent' => $amount]);
            }
        });

        return back()->with('success', __('Rent payments created successfully!'));
    }
}
