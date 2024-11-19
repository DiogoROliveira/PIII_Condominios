<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Unit;


class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::orderBy('id', 'asc')->get();
        $total = Tenant::count();
        return view('admin.tenants.home', compact('tenants', 'total'));
    }

    public function create()
    {
        $users = User::get();
        $units = Unit::with('block.condominium')->get();
        return view('admin.tenants.create', compact('users', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'nullable|date|after_or_equal:lease_start_date',
            'status' => 'required|in:active,inactive,pending,terminated',
            'notes' => 'nullable|string|max:500'
        ]);

        $unit = Unit::findOrFail($request->unit_id);
        if ($unit->status != 'vacant') {
            return redirect()->back()->withErrors(['error' => __('Unit is not vacant.')]);
        }

        if ($request->status == 'active') {
            $unit->update(['status' => 'occupied']);
        } else if ($request->status == 'inactive' || $request->status == 'terminated') {
            $unit->update(['status' => 'vacant']);
        } else {
            $unit->update(['status' => 'reserved']);
        }


        $tenant = Tenant::create([
            'user_id' => $request->user_id,
            'lease_start_date' => $request->lease_start_date,
            'lease_end_date' => $request->lease_end_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        $unit->update([
            'tenant_id' => $tenant->id
        ]);

        return redirect()->route('admin.tenants')->with('success', __('Tenant created successfully.'));
    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        $users = User::get();
        $units = Unit::with('block.condominium')->get();
        return view('admin.tenants.edit', compact('tenant', 'users', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'nullable|date|after_or_equal:lease_start_date',
            'status' => 'required|in:active,inactive,pending,terminated',
            'notes' => 'nullable|string|max:500'
        ]);

        $tenant = Tenant::findOrFail($id);
        $unit = Unit::findOrFail($request->unit_id);


        if ($unit->status != 'vacant' && $tenant->unit_id != $unit->id) {
            return redirect()->back()->withErrors(['error' => __('Unit is not vacant.')]);
        }


        $statusTransitions = [
            'active_to_inactive' => 'vacant',
            'active_to_terminated' => 'vacant',
            'active_to_pending' => 'reserved',
            'pending_to_active' => 'occupied',
            'pending_to_inactive' => 'vacant',
            'pending_to_terminated' => 'vacant',
            'inactive_to_active' => 'occupied',
            'inactive_to_pending' => 'reserved',
            'inactive_to_terminated' => 'vacant',
            'terminated_to_active' => 'occupied',
            'terminated_to_inactive' => 'vacant',
            'terminated_to_pending' => 'reserved',
        ];

        $transitionKey = "{$tenant->status}_to_{$request->status}";


        if (isset($statusTransitions[$transitionKey])) {
            $unit->update([
                'status' => $statusTransitions[$transitionKey],
            ]);
        }

        // Atualiza os dados do tenant
        $tenant->update([
            'user_id' => $request->user_id,
            'lease_start_date' => $request->lease_start_date,
            'lease_end_date' => $request->lease_end_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.tenants')->with('success', __('Tenant updated successfully.'));
    }


    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();
        return redirect()->route('admin.tenants')->with('success', __('Tenant deleted successfully.'));
    }
}
