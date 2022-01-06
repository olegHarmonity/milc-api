<?php

use App\Http\Controllers\Media\AudioController;
use App\Http\Controllers\Media\FileController;
use App\Http\Controllers\Media\ImageController;
use App\Http\Controllers\Media\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\EmailController;
use App\Http\Controllers\Core\MoneyController;
use App\Http\Controllers\Core\FeedbackController;
use App\Http\Controllers\Core\GeneralAdminSettingsController;
use App\Http\Controllers\Core\NotificationController;

Route::post('/send-email', [
    EmailController::class,
    'sendEmail'
])->name('sendEmail');

Route::apiResource('images', ImageController::class);
Route::apiResource('videos', VideoController::class);
Route::apiResource('files', FileController::class);
Route::apiResource('audios', AudioController::class);
Route::apiResource('feedbacks', FeedbackController::class);

Route::post('/exchange-currency', [
    MoneyController::class,
    'exchangeCurrency'
])->name('exchangeCurrency');

Route::apiResource('admin-settings', GeneralAdminSettingsController::class);

Route::get('/notifications/has-unread', [
    NotificationController::class,
    'hasUnreadNotifications'
])->name('hasUnreadNotifications');

Route::get('/notifications/mark-all-as-read', [
    NotificationController::class,
    'markAllAsRead'
])->name('markAllAsRead');

Route::put('/notifications/mark-as-read/{id}', [
    NotificationController::class,
    'markAsRead'
])->name('markAsRead');

Route::apiResource('notifications', NotificationController::class);

