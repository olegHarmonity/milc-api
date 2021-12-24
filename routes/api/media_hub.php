<?php
use App\Http\Controllers\MediaHubApi\MediaHubController;
use Illuminate\Support\Facades\Route;



Route::post('/media-token', [MediaHubController::class, 'getAuthToken'])->name('media_token');
Route::post('/media-upload', [MediaHubController::class, 'startUpload'])->name('media_upload');
// Route::post('/media-hub/file-upload', [MediaHubController::class, 'fileUpload'])->name('file_upload');
Route::apiResource('/media-hub', MediaHubController::class);
