<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookStockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/users', UserController::class)->except('show', 'create');
    Route::get('/users/create/{student}', [UserController::class, 'create'])->name('users.create');

    Route::resource('/students', StudentController::class)->except('show');

    Route::resource('/books', BookController::class)->except('show');
    Route::get('/books/{book}/stock', [BookStockController::class, 'form'])->name('books.stock.form');
    Route::post('/books/{book}/stock', [BookStockController::class, 'store'])->name('books.stock.store');

    Route::resource('/loans', LoanController::class)->except('show');
});
