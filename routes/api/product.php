<?php
use App\Http\Controllers\Product\MovieContentTypeController;
use App\Http\Controllers\Product\MovieFormatController;
use App\Http\Controllers\Product\MovieGenreController;
use App\Http\Controllers\Product\MovieRightController;
use App\Http\Controllers\Product\PersonController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\RightsBundleController;
use App\Http\Controllers\Product\RightsInfoController;

Route::put('/products/change-status/{id}', [
    ProductController::class,
    'updateStatus'
])->name('updateStatus');


Route::get('/products/by-category/{categoryId}', [
    ProductController::class,
    'getProductsByCategory'
])->name('getProductsByCategory');

Route::get('/products/custom-bundles/{id}', [
    ProductController::class,
    'showCustomBundles'
])->name('showCustomBundles');

Route::apiResource('products', ProductController::class);
Route::apiResource('movie-rights', MovieRightController::class);
Route::apiResource('movie-formats', MovieFormatController::class);

Route::apiResource('movie-genres', MovieGenreController::class);
Route::apiResource('movie-content-types', MovieContentTypeController::class);
Route::apiResource('persons', PersonController::class);

Route::get('/rights-info/{id}', [
    RightsInfoController::class,
    'show'
]);


Route::apiResource('rights-bundles', RightsBundleController::class);
