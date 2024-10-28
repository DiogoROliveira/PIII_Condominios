<?php

use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;



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

    // Condominium Routes
    route::get('admin/dashboard/condominiums', [CondominiumController::class, 'index'])->name('admin.condominiums');
    route::get('admin/dashboard/condominiums/create', [CondominiumController::class, 'create'])->name('admin.condominiums.create');
    route::post('admin/dashboard/condominiums/create', [CondominiumController::class, 'store'])->name('admin.condominiums.store');
    route::get('admin/dashboard/condominiums/{id}/edit', [CondominiumController::class, 'edit'])->name('admin.condominiums.edit');
    route::put('admin/dashboard/condominiums/{id}', [CondominiumController::class, 'update'])->name('admin.condominiums.update');
    route::delete('admin/dashboard/condominiums/{id}', [CondominiumController::class, 'destroy'])->name('admin.condominiums.destroy');

    // Block Routes
    route::get('admin/dashboard/blocks', [BlockController::class, 'index'])->name('admin.blocks');
    route::get('admin/dashboard/blocks/create', [BlockController::class, 'create'])->name('admin.blocks.create');
    route::post('admin/dashboard/blocks/create', [BlockController::class, 'store'])->name('admin.blocks.store');
    route::get('admin/dashboard/blocks/{id}/edit', [BlockController::class, 'edit'])->name('admin.blocks.edit');
    route::put('admin/dashboard/blocks/{id}', [BlockController::class, 'update'])->name('admin.blocks.update');
    route::delete('admin/dashboard/blocks/{id}', [BlockController::class, 'destroy'])->name('admin.blocks.destroy');
});
