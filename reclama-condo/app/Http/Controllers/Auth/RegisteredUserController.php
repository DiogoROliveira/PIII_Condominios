<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = json_decode(File::get(storage_path('app/country-phones.json')), true)['countries'];
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone_number' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $phone = $request->country_code . $request->phone_number;

        $user = User::create([
            'name' => $request->name,
            'phone' => $phone,
            'email' => Crypt::encrypt($request->email),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $userRole = \App\Models\Role::where('name', 'user')->first();

        if ($userRole) {
            $user->role()->associate($userRole);
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
