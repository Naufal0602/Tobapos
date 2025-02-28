<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StrukController;
use Illuminate\Support\Facades\Route;
//company_profile
Route::get('/', [CompanyProfileController::class, 'index']);
Route::post('/', [ContactController::class, 'SendMessage'])->name('send.message');



Route::group(['prefix' => '/dashboard', 'middleware' => ['auth'], 'as' => 'dashboard.'], static function () {
    Route::get('/', static function () {
        return view('dashboard.index');
    })->name('index');

    // Company Profile
    Route::group(['prefix' => '/company-profile', 'as' => 'company_profile.'], static function () {
        Route::get('/edit/{id}', [CompanyProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [CompanyProfileController::class, 'update'])->name('update');
    });

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class);

    // Pemasukan
    Route::get('income', [TransactionController::class, 'income'])->name('income');

    // Product
    Route::resource('products', ProductController::class);

    Route::get('/product/menu', function () {
        return view('dashboard.product.menu');
    })->name('products.menu');


    // Transaction
    Route::resource('transactions', TransactionController::class);
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
