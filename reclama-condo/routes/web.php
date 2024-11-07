<?php

use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Auth\RegisteredAdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('user.dashboard');
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

    Route::get('admin/dashboard/blocks/{condominium}', [BlockController::class, 'getBlocks'])->name('admin.blocks.get');

    // Unit Routes
    route::get('admin/dashboard/units', [UnitController::class, 'index'])->name('admin.units');
    route::get('admin/dashboard/units/create', [UnitController::class, 'create'])->name('admin.units.create');
    route::post('admin/dashboard/units/create', [UnitController::class, 'store'])->name('admin.units.store');
    route::get('admin/dashboard/units/{id}/edit', [UnitController::class, 'edit'])->name('admin.units.edit');
    route::put('admin/dashboard/units/{id}', [UnitController::class, 'update'])->name('admin.units.update');
    route::delete('admin/dashboard/units/{id}', [UnitController::class, 'destroy'])->name('admin.units.destroy');

    // Tenant Routes
    route::get('admin/dashboard/tenants', [TenantController::class, 'index'])->name('admin.tenants');
    route::get('admin/dashboard/tenants/create', [TenantController::class, 'create'])->name('admin.tenants.create');
    route::post('admin/dashboard/tenants/create', [TenantController::class, 'store'])->name('admin.tenants.store');
    route::get('admin/dashboard/tenants/{id}/edit', [TenantController::class, 'edit'])->name('admin.tenants.edit');
    route::put('admin/dashboard/tenants/{id}', [TenantController::class, 'update'])->name('admin.tenants.update');
    route::delete('admin/dashboard/tenants/{id}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');

    // User Routes
    route::get('admin/dashboard/users', [UserController::class, 'index'])->name('admin.users');
    route::get('admin/dashboard/users/create', [UserController::class, 'create'])->name('admin.users.create');
    route::post('admin/dashboard/users/create', [UserController::class, 'store'])->name('admin.users.store');
    route::get('admin/dashboard/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    route::put('admin/dashboard/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    route::delete('admin/dashboard/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Admin Register
    route::get('admin/dashboard/register-admin', [RegisteredAdminController::class, 'create'])->name('admin.register');
    route::post('admin/dashboard/register-admin', [RegisteredAdminController::class, 'store'])->name('admin.register.store');
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
    Route::get('dashboard/complaints/{id}/download', [ComplaintController::class, 'download'])->name('complaints.download');
    Route::get('dashboard/complaints/{id}', [ComplaintController::class, 'show'])->name('complaints.show');

    Route::middleware(['admin'])->group(function () {
        Route::get('admin/dashboard/complaints', [ComplaintController::class, 'index_admin'])->name('admin.complaints');
        Route::get('admin/dashboard/complaints/{id}/edit', [ComplaintController::class, 'edit'])->name('admin.complaints.edit');
        Route::put('admin/dashboard/complaints/{id}', [ComplaintController::class, 'update'])->name('admin.complaints.update');
        Route::delete('admin/dashboard/complaints/{id}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');
        Route::get('admin/dashboard/complaints/{id}/download', [ComplaintController::class, 'download'])->name('admin.complaints.download');
    });
});
