<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\PayPalController;


Route::put('/checkout/pay-stripe/{orderNumber}', [
    StripeController::class,
    'pay'
])->name('pay-stripe');



Route::put('/checkout/pay-paypal/{orderNumber}', [
    PayPalController::class,
    'pay'
])->name('pay-paypal');


Route::put('/payment-success/{id}', [PayPalController::class, 'paymentSuccess']);
Route::put('/payment-error/{id}', [PayPalController::class, 'paymentError']);
