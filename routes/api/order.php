<?php

use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;


Route::put('/orders/change-currency/{id}', [
    OrderController::class,
    'changeCurrency'
])->name('changeCurrency');

Route::apiResource('orders', OrderController::class);

