<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentalController;

Route::get('/', function () {
    return view('main');
});

// Routes untuk Peralatan Camping
Route::prefix('equipment')->name('equipment.')->group(function () {
    Route::get('/', [EquipmentController::class, 'index'])->name('index');
    Route::get('/create', [EquipmentController::class, 'create'])->name('create');
    Route::post('/store', [EquipmentController::class, 'store'])->name('store');
    Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->name('edit');
    Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('update');
    Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');
    Route::get('/{equipment}', [EquipmentController::class, 'show'])->name('show');
});

// Routes untuk Pelanggan
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/store', [CustomerController::class, 'store'])->name('store');
    Route::get('/{customers}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{customers}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{customers}', [CustomerController::class, 'destroy'])->name('destroy');
    Route::get('/{customers}', [CustomerController::class, 'show'])->name('show');
});

// Routes untuk Rental
Route::prefix('rentals')->name('rentals.')->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('index');
    Route::get('/create', [RentalController::class, 'create'])->name('create');
    Route::post('/store', [RentalController::class, 'store'])->name('store');
    Route::get('/{rental}/edit', [RentalController::class, 'edit'])->name('edit');
    Route::put('/{rental}', [RentalController::class, 'update'])->name('update');
    Route::delete('/{rental}', [RentalController::class, 'destroy'])->name('destroy');
    Route::get('/{rental}', [RentalController::class, 'show'])->name('show');

    // Rute khusus untuk pengembalian alat
    Route::post('/{rental}/return', [RentalController::class, 'returnEquipment'])->name('return');
});
