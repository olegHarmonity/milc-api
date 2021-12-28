<?php

use App\Http\Controllers\MediaHubApi\MediaHubController;
use Illuminate\Support\Facades\Route;

Route::post('/media-token', [MediaHubController::class, 'getAuthToken'])->name('media_token');
// Route::post('/media-hub/file-upload', [MediaHubController::class, 'fileUpload'])->name('file_upload');
Route::apiResource('/media-hub', MediaHubController::class);

// s3 multipart file upload
Route::post('/s3/multipart', [MediaHubController::class, 'createMultipartUpload']);
Route::get('/s3/multipart/{uploadId}', [MediaHubController::class, 'listParts']);
Route::get('/s3/multipart/{uploadId}/batch', [MediaHubController::class, 'prepareUploadParts']);
Route::post('/s3/multipart/{uploadId}/complete', [MediaHubController::class, 'completeMultipartUpload']);
Route::delete('/s3/multipart/{uploadId}', [MediaHubController::class, 'abortMultipartUpload']);

// Items
Route::get('/assets/{assetId}/items', [MediaHubController::class, 'getItemsForAsset']);
Route::delete('/items/{itemId}', [MediaHubController::class, 'deleteItem']);
