<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('refresh');
});
