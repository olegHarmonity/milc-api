<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PayPalController;

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
    return view('welcome');
});

Route::get('auth/reset-password/{email}')
    ->name('password.reset');

    Route::get('handle-payment', [PayPalController::class, 'payment'])->name('payment');

    Route::get('cancel-payment', [PayPalController::class, 'cancel'])->name('payment.cancel');

    Route::get('payment-success', [PayPalController::class, 'success'])->name('payment.success');

