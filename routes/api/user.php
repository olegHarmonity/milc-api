<?php

use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/me', [UserController::class, 'me'])
    ->name('me');

Route::get('/email-exists', [UserController::class, 'emailExists'])
    ->name('email_exists');

Route::post('/register', [UserController::class, 'register'])
    ->name('register');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->name('update');

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);

Route::post('/reset-password',  [ForgotPasswordController::class, 'reset']);

Route::post('/change-password',  [UserController::class, 'change_password']);
