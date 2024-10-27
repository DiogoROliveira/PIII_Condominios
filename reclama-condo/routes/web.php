<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
    route::get('admin/dashboard/condominiums', [CondominiumController::class, 'index'])->name('admin.condominiums');
    route::get('admin/dashboard/condominiums/create', [CondominiumController::class, 'create'])->name('admin.condominiums.create');
    route::post('admin/dashboard/condominiums/create', [CondominiumController::class, 'store'])->name('admin.condominiums.store');
    route::get('admin/dashboard/condominiums/{id}/edit', [CondominiumController::class, 'edit'])->name('admin.condominiums.edit');
    route::put('admin/dashboard/condominiums/{id}', [CondominiumController::class, 'update'])->name('admin.condominiums.update');
    route::delete('admin/dashboard/condominiums/{id}', [CondominiumController::class, 'destroy'])->name('admin.condominiums.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/dashboard/complaint-types', [ComplaintTypeController::class, 'index'])->name('admin.complaint-types');
    Route::get('admin/dashboard/complaint-types/create', [ComplaintTypeController::class, 'create'])->name('admin.complaint-types.create');
    Route::post('admin/dashboard/complaint-types', [ComplaintTypeController::class, 'store'])->name('admin.complaint-types.store');
    Route::get('admin/dashboard/complaint-types/{id}/edit', [ComplaintTypeController::class, 'edit'])->name('admin.complaint-types.edit');
    Route::put('admin/dashboard/complaint-types/{id}', [ComplaintTypeController::class, 'update'])->name('admin.complaint-types.update');
    Route::delete('admin/dashboard/complaint-types/{id}', [ComplaintTypeController::class, 'destroy'])->name('admin.complaint-types.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('dashboard/complaints', [ComplaintController::class, 'index_user'])->name('complaints.index');
    Route::post('dashboard/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    
    Route::middleware(['admin'])->group(function () {
        Route::get('admin/dashboard/complaints', [ComplaintController::class, 'index_admin'])->name('admin.complaints');
        Route::get('admin/dashboard/complaints/{id}/edit', [ComplaintController::class, 'edit'])->name('admin.complaints.edit');
        Route::put('admin/dashboard/complaints/{id}', [ComplaintController::class, 'update'])->name('admin.complaints.update');
        Route::delete('admin/dashboard/complaints/{id}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');
    });
});