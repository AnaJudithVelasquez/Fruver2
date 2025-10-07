<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Productos - SuperAdmin y Admin
    Route::resource('products', ProductController::class)->middleware('role:SuperAdministrador,Administrador');

    // Ventas - Todos
    Route::resource('sales', SaleController::class)->middleware('role:SuperAdministrador,Administrador,Empleado');
    Route::get('/pdf.blade/pdf', [SaleController::class, 'generatePDF'])->name('sales.pdf')->middleware('role:SuperAdministrador,Administrador,Empleado');

    // Usuarios - SuperAdmin
    Route::resource('users', UserController::class)->middleware('role:SuperAdministrador');
});

require __DIR__.'/auth.php';
