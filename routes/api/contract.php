<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\ContractController;


Route::get('/contracts/admin-default', [ContractController::class, 'showAdminDefaultContract']);

Route::get('/contracts/organisation-default', [ContractController::class, 'showOrganisationDefaultContract']);

Route::put('/contracts/admin-default', [ContractController::class, 'updateAdminDefaultContract']);

Route::put('/contracts/organisation-default', [ContractController::class, 'updateOrganisationDefaultContract']);

Route::get('/contracts', [ContractController::class, 'index']);

Route::get('/contracts/{id}', [ContractController::class, 'show']);

Route::get('/checkout/contract/{orderNumber}', [ContractController::class, 'showCheckoutContract']);