<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\OrganisationTypeController;
use Illuminate\Support\Facades\Route;


Route::put('/organisations/change-status/{id}', [
    OrganisationController::class,
    'updateStatus'
])->name('updateOrganisationStatus');

Route::apiResource('organisations', OrganisationController::class);

Route::apiResource('organisation-types', OrganisationTypeController::class);

