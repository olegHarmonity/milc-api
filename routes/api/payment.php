<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\StripeController;


Route::put('/orders/pay-stripe/{id}', [
    StripeController::class,
    'pay'
])->name('pay');

