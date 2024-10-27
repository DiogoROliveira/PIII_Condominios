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
        return view('admin.condominiums.home');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'admin_id' => 'required|exists:users,id',
            // other validation rules...
        ]);

        // Custom validation rule to ensure the user is an admin
        $validator->after(function ($validator) use ($request) {
            $user = User::find($request->admin_id);
            if ($user && $user->role_id !== 1) {
                $validator->errors()->add('admin_id', 'The selected user must be an admin.');
            }
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $condominium = Condominium::create($request->all());
        return response()->json($condominium, 201);
    }
}
