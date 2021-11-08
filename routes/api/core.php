<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('images', ImageController::class);
Route::apiResource('videos', VideoController::class);
Route::apiResource('files', FileController::class);
Route::apiResource('audios', AudioController::class);
