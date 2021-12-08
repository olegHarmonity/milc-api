<?php

use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::put('/checkout/change-currency/{orderNumber}', [
    OrderController::class,
    'changeCurrency'
])->name('changeCurrency');

Route::put('/checkout/update-contract/{orderNumber}', [
    OrderController::class,
    'updateContractStatus'
])->name('updateContractStatus');

Route::get('/checkout/{orderNumber}', [OrderController::class, 'showCheckoutOrder']);

Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::get('/orders', [OrderController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);

