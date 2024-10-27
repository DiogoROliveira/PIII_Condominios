<?php

use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin Routes

Route::middleware(['auth', 'admin'])->group(function () {

    route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    route::get('admin/dashboard/condominiums', [CondominiumController::class, 'index'])->name('admin.condominiums');
});
