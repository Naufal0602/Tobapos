<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CompanyProfileController::class, 'index']);

Route::group(['prefix' => '/dashboard', 'middleware' => ['auth'], 'as' => 'dashboard.'], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('index');

    // Company Profile
    Route::group(['prefix' => '/company-profile', 'as' => 'company_profile.'], function () {
        Route::get('/edit', [CompanyProfileController::class, 'edit'])->name('company_profile.edit');
        Route::patch('/update', [CompanyProfileController::class, 'update'])->name('company_profile.update');
    });

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class);

    // Product
    Route::resource('products', ProductController::class);

    // Product
    Route::resource('products', ProductController::class);

    // Transaction
    Route::resource('transactions', TransactionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
