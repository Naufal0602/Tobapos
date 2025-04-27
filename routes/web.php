<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PrintersController;
use Illuminate\Support\Facades\Route;
//company_profile
Route::get('/', [CompanyProfileController::class, 'index']);
Route::post('/', [ContactController::class, 'SendMessage'])->name('send.message');



Route::group(['prefix' => '/dashboard', 'middleware' => ['auth'], 'as' => 'dashboard.'], static function () {
    Route::get('/', static function () {
        return view('dashboard.index');
    })->name('index');

    // Company Profile
// Di routes/web.php
Route::group(['prefix' => 'company-profile', 'as' => 'company_profile.'], function () {
    Route::get('/edit', [CompanyProfileController::class, 'edit'])->name('edit'); // Tidak perlu parameter ID
    Route::put('/update', [CompanyProfileController::class, 'update'])->name('update'); // Tidak perlu parameter ID
});

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class);

    // Pemasukan
    Route::get('income', [TransactionController::class, 'income'])->name('income');

    // Product
    Route::resource('products', ProductController::class);
    Route::get('/dashboard/products/printers', [ProductController::class, 'getAvailablePrinters'])->name('products.printers');
    Route::post('/dashboard/products/set-printer', [ProductController::class, 'setPrinter'])->name('products.setPrinter');
    Route::get('/product/menu', function () {
        return view('dashboard.product.menu');
    })->name('products.menu');
    Route::post('/product/update-stock', [ProductController::class, 'updateStock']);

    Route::get('/dashboard/products/index', [PrintersController::class , 'index']);
    Route::post('/dashboard/printers', [PrintersController::class, 'store'])->name('printers.store');
    Route::delete('/dashboard/printers/{id}', [PrintersController::class, 'destroy'])->name('printers.destroy');


    // Transaction
    Route::resource('transactions', TransactionController::class);
    //contact
    Route::resource('contact', ContactController::class); 

    //print
    Route::post('/print/receipt', [TransactionController::class, 'printReceipt'])->name('print.receipt');
    Route::post('/print/receipt-via-powershell', [PrintController::class, 'printReceiptViaPowerShell'])->name('print.receipt-via-powershell');    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
