<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login-verify', [AuthController::class, 'loginVerify'])
        ->name('login_verify');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('refresh');
    
    Route::get('/verify-email/{verification_code}', [AuthController::class, 'verifyUser'])
    ->name('verify_user');
    
    Route::get('/resend-verification-email/{email}', [AuthController::class, 'resendVerificationEmail'])
    ->name('redsend_verification_email');
        
});
