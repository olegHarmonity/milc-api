<?php
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserActivityController;

Route::get('/me', [
    UserController::class,
    'me'
])->name('me');

Route::get('/email-exists', [
    UserController::class,
    'emailExists'
])->name('email_exists');

Route::post('/register', [
    UserController::class,
    'register'
])->name('register');

Route::post('/forgot-password', [
    ForgotPasswordController::class,
    'forgot'
]);

Route::post('/reset-password', [
    ForgotPasswordController::class,
    'reset'
]);

Route::post('/change-password', [
    UserController::class,
    'change_password'
]);

Route::get('/users/saved-products', [
    UserController::class,
    'getSavedProducts'
]);

Route::post('/users/save-product', [
    UserController::class,
    'saveProduct'
]);

Route::delete('/users/delete-saved-product/{productId}', [
    UserController::class,
    'deleteSavedProduct'
]);

Route::middleware([
    'auth'
])->group(function () {
    Route::apiResource('users', UserController::class)->middleware('auth');
});

Route::get('/users/user-activities/{userId}', [
    UserActivityController::class,
    'getUserActivitiesByUser'
]);
    

Route::apiResource('user-activities', UserActivityController::class);
