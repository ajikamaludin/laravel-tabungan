<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');
    Route::get('/maintance', [GeneralController::class, 'maintance'])->name('maintance');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Role
    Route::resource('/roles', RoleController::class);

    // Setting
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('setting.update');

    // Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    // Transaction
    Route::get('/trx', [TransactionController::class, 'index'])->name('trx.index');
    Route::get('/trx/create', [TransactionController::class, 'create'])->name('trx.create');
    Route::post('/trx', [TransactionController::class, 'store'])->name('trx.store');
    Route::delete('/trx/{trx}', [TransactionController::class, 'destroy'])->name('trx.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
