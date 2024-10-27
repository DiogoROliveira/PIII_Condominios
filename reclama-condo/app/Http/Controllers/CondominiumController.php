<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Condominium;

class CondominiumController extends Controller
{
    public function index()
    {
        $condominiums = Condominium::orderBy('id', 'asc')->get();
        $total = Condominium::count();
        return view('admin.condominiums.home', compact('condominiums', 'total'));
    }

    public function create()
    {
        $users = User::where('role_id', 1)->get();
        return view('admin.condominiums.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'admin_id' => 'required|exists:users,id',
            'email' => 'nullable|email',
            'number_of_blocks' => 'required|integer|min:1',
        ]);



        // Custom validation rule to ensure the user is an admin
        $validator->after(function ($validator) use ($request) {
            $user = User::find($request->admin_id);
            if ($user && $user->role_id !== 1) {
                $validator->errors()->add('admin_id', 'The selected user must be an admin.');
            }
        });

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            return redirect()->route('admin.condominiums.create');
        }

        $condominium = Condominium::create($request->all());
        if ($condominium) {
            session()->flash('success', 'Condominium created successfully.');
            return redirect()->route('admin.condominiums');
        } else {
            session()->flash('error', 'Failed to create condominium.');
            return redirect()->route('admin.condominiums');
        }
    }

    public function edit($id)
    {
        $condominium = Condominium::find($id);
        return view('admin.condominiums.edit', compact('condominium'));
    }
}
