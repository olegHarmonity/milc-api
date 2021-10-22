<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group([], function ($router) {

    Route::get('/me',[UserController::class, 'me'])
        ->name('me');
});
