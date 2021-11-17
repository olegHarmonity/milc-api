<?php
use App\Http\Controllers\MovieContentTypeController;
use App\Http\Controllers\MovieFormatController;
use App\Http\Controllers\MovieGenreController;
use App\Http\Controllers\MovieRightController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::put('/products/change-status/{id}', [
    ProductController::class,
    'updateStatus'
])->name('updateStatus');

Route::apiResource('products', ProductController::class);
Route::apiResource('movie-rights', MovieRightController::class);
Route::apiResource('movie-formats', MovieFormatController::class);
Route::apiResource('movie-genres', MovieGenreController::class);
Route::apiResource('movie-content-types', MovieContentTypeController::class);
Route::apiResource('persons', PersonController::class);
