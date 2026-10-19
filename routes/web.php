<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleUser'])->name('users.status');

    Route::get('/tariffs', [AdminController::class, 'tariffs'])->name('tariffs.index');
    Route::get('/tariffs/create', [AdminController::class, 'createTariff'])->name('tariffs.create');
    Route::post('/tariffs', [AdminController::class, 'storeTariff'])->name('tariffs.store');
    Route::get('/tariffs/{tariff}/edit', [AdminController::class, 'editTariff'])->name('tariffs.edit');
    Route::put('/tariffs/{tariff}', [AdminController::class, 'updateTariff'])->name('tariffs.update');
    Route::delete('/tariffs/{tariff}', [AdminController::class, 'destroyTariff'])->name('tariffs.destroy');

    Route::get('/areas', [AdminController::class, 'areas'])->name('areas.index');
    Route::get('/areas/create', [AdminController::class, 'createArea'])->name('areas.create');
    Route::post('/areas', [AdminController::class, 'storeArea'])->name('areas.store');
    Route::get('/areas/{area}/edit', [AdminController::class, 'editArea'])->name('areas.edit');
    Route::put('/areas/{area}', [AdminController::class, 'updateArea'])->name('areas.update');
    Route::delete('/areas/{area}', [AdminController::class, 'destroyArea'])->name('areas.destroy');

    Route::get('/vehicles', [AdminController::class, 'vehicles'])->name('vehicles.index');
    Route::get('/vehicles/create', [AdminController::class, 'createVehicle'])->name('vehicles.create');
    Route::post('/vehicles', [AdminController::class, 'storeVehicle'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', [AdminController::class, 'editVehicle'])->name('vehicles.edit');
    Route::put('/vehicles/{vehicle}', [AdminController::class, 'updateVehicle'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [AdminController::class, 'destroyVehicle'])->name('vehicles.destroy');

    Route::get('/logs', [AdminController::class, 'logs'])->name('logs.index');
});

Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/', [PetugasController::class, 'index'])->name('index');
    Route::post('/transaksi/masuk', [PetugasController::class, 'vehicleEntry'])->name('entry');
    Route::post('/transaksi/{transaction}/keluar', [PetugasController::class, 'vehicleExit'])->name('exit');
    Route::get('/transaksi/{transaction}/struk', [PetugasController::class, 'receipt'])->name('receipt');
});

Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/', [OwnerController::class, 'index'])->name('report');
});
