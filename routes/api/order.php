<?php

use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\ContractController;
use App\Http\Controllers\Order\DownloadPdfController;

Route::put('/checkout/change-currency/{orderNumber}', [
    OrderController::class,
    'changeCurrency'
])->name('changeCurrency');

Route::put('/checkout/update-contract/{orderNumber}', [
    OrderController::class,
    'updateContractStatus'
])->name('updateContractStatus');

Route::put('/checkout/mark-assets-sent/{orderNumber}', [
    OrderController::class,
    'markAssetsAsSent'
])->name('markAssetsAsSent');

Route::put('/checkout/mark-assets-received/{orderNumber}', [
    OrderController::class,
    'markAssetsAsReceived'
])->name('markAssetsAsReceived');

Route::put('/checkout/mark-completed/{orderNumber}', [
    OrderController::class,
    'markAsCompleted'
])->name('markAsCompleted');

Route::put('/checkout/mark-rejected/{orderNumber}', [
    OrderController::class,
    'markAsRejected'
])->name('markAsRejected');

Route::put('/checkout/mark-cancelled/{orderNumber}', [
    OrderController::class,
    'markAsCancelled'
])->name('markAsCancelled');

Route::put('/checkout/mark-refunded/{orderNumber}', [
    OrderController::class,
    'markAsRefunded'
])->name('markAsRefunded');

Route::put('/checkout/mark-paid/{orderNumber}', [
    OrderController::class,
    'markAsPaid'
])->name('markAsPaid');

Route::put('/checkout/pay-bank-transfer/{orderNumber}', [
    OrderController::class,
    'payViaBankTransfer'
])->name('payViaBankTransfer');

Route::get('/checkout/{orderNumber}', [OrderController::class, 'showCheckoutOrder']);

Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::get('/orders', [OrderController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);

Route::get('/download-order-pdf/{orderNumber}',[DownloadPdfController::class, 'downloadOrderPDF']);

Route::get('/download-contract-pdf/{orderNumber}',[DownloadPdfController::class, 'downloadContractPDF']);



