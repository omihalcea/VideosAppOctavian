<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiMultimediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/uploads', [ApiMultimediaController::class, 'index']);
    Route::get('/uploads/profile', [ApiMultimediaController::class, 'profile']);
    Route::post('/uploads', [ApiMultimediaController::class, 'store']);
    Route::put('/uploads/{id}', [ApiMultimediaController::class, 'update']);
    Route::get('/uploads/{id}', [ApiMultimediaController::class, 'show']);
    Route::delete('/uploads/{id}', [ApiMultimediaController::class, 'destroy']);
});


