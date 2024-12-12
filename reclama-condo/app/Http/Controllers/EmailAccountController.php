<?php

namespace App\Http\Controllers;

use App\Notifications\TenantAccountNotification;
use Illuminate\Http\Request;
use App\Models\Tenant;

class EmailAccountController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('admin.mail_account.home', compact('tenants'));
    }

    public function send(Request $request)
    {
        $tenant = Tenant::findOrFail($request->tenant_id);

        try {
            $tenant->user->notify(new TenantAccountNotification($tenant));
            return redirect()->back()->with('success', __('Email sent successfully!'), $tenant->user->email);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage(), $e->getTraceAsString());
        }
    }
}
