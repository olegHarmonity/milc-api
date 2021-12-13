<?php
use App\Http\Controllers\MediaHubApi\MediaHubController;
use Illuminate\Support\Facades\Route;



Route::post('/media-token', [MediaHubController::class, 'getAuthToken'])->name('media_token');
Route::apiResource('/media-hub', MediaHubController::class);
