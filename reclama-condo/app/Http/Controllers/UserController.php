<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        $total = User::count();
        return view('admin.users.home', compact('users', 'total'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => Crypt::encrypt($request->email),
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', __('User created successfully.'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = Crypt::encrypt($request->email);
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', __('User updated successfully.'));
    }

    public function destroy($id)
    {
        if ($id == auth()->user()->id) {
            return redirect()->route('admin.users')->with('error', __('You cannot delete your own account this way.'));
        }

        if (Tenant::where('user_id', $id)->exists()) {
            return redirect()->route('admin.users')->with('error', __('You cannot delete an account that is assigned to a tenant.'));
        }

        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('success', __('User deleted successfully.'));
    }
}
