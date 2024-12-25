<?php

namespace App\Http\Controllers;

use App\Notifications\TenantAccountNotification;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class EmailAccountController extends Controller
{
    public function index()
    {
        // Buscar users que têm tenants, com todos os relacionamentos necessários
        $users = User::whereHas('tenants')
            ->with(['tenants.units.block.condominium', 'tenants.monthly_payments'])
            ->get();

        return view('admin.mail_account.home', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email'
        ]);

        try {
            $user = User::with(['tenants.units.block.condominium', 'tenants.monthly_payments'])
                ->findOrFail($request->user_id);

            if (Crypt::decrypt($user->email) !== $request->email) {
                return redirect()->back()->with('error', __('Invalid email address for this user'));
            }

            $user->notify(new TenantAccountNotification($user));

            return redirect()->back()->with('success', __('Email sent successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Failed to send email. Please try again later.'));
        }
    }
}
