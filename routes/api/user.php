<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/me', [UserController::class, 'me'])
    ->name('me');

Route::post('/register', [UserController::class, 'register'])
    ->name('register');

