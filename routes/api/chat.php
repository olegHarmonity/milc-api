<?php
use App\Http\Controllers\Chat\ConversationController;
use Illuminate\Support\Facades\Route;



Route::get('/conversations', [ConversationController::class, 'index']);
Route::get('/conversations/{conversation}', [ConversationController::class, 'show']);
Route::post('/conversations', [ConversationController::class, 'startChat']);
Route::put('/conversations/{conversation}', [ConversationController::class, 'update']);
Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroyConversation']);
Route::delete('/conversations/message/{message}', [ConversationController::class, 'destroyMessage']);
Route::post('/conversations/{conversation}', [ConversationController::class, 'sendMessage']);
