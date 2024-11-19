<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {

        $totalUsers = User::count();
        $totalCondominiums = auth()->user()->condominiums->count();

        return view('admin.dashboard', compact('totalUsers', 'totalCondominiums'));
    }
}
