<?php

use App\Http\Controllers\Media\AudioController;
use App\Http\Controllers\Media\FileController;
use App\Http\Controllers\Media\ImageController;
use App\Http\Controllers\Media\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\EmailController;


Route::post('/send-email', [
    EmailController::class,
    'sendEmail'
])->name('sendEmail');

Route::apiResource('images', ImageController::class);
Route::apiResource('videos', VideoController::class);
Route::apiResource('files', FileController::class);
Route::apiResource('audios', AudioController::class);
