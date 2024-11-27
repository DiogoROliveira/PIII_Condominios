<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Crypt;

class RegisteredAdminController extends Controller
{
    public function create()
    {
        return view('admin.register-admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => Crypt::encrypt($request->email),
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);


        Auth::login($user);

        return redirect(route('admin.dashboard', absolute: false));
    }
}
