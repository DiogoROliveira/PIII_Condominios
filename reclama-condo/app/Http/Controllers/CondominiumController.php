<?php

namespace App\Http\Controllers;

use App\Models\Block;
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
            'postal_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'number_of_blocks' => 'required|integer|min:1',
        ]);




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
        $users = User::where('role_id', 1)->get();
        return view('admin.condominiums.edit', compact('condominium', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'admin_id' => 'required|exists:users,id',
            'postal_code' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'number_of_blocks' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.condominiums.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $condominium = Condominium::find($id);
        $condominium->update($validator->validated());

        session()->flash('success', 'Condominium updated successfully.');
        return redirect()->route('admin.condominiums');
    }


    public function destroy($id)
    {
        if (Block::where('condominium_id', $id)->exists()) {
            return redirect()->route('admin.condominiums')->with('error', 'Condominium cannot be deleted because it has blocks.');
        }

        Condominium::findOrFail($id)->delete();
        return redirect()->route('admin.condominiums')->with('success', 'Condominium deleted successfully.');
    }
}
