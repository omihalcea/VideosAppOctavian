<?php

use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos/manage', [VideosController::class, 'manage'])
    ->middleware(['auth', 'can:manage-videos'])
    ->name('videos.manage');

Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
