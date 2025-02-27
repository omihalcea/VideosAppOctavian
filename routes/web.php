<?php

use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Grup de rutes protegides per autenticació i permisos
Route::middleware(['auth'])->group(function () {
    Route::prefix('videos/manage')->group(function () {
        Route::get('/', [VideosController::class, 'manage'])->name('videos.manage')->middleware('can:manage_videos');
        Route::get('/create', [VideosController::class, 'create'])->name('manage.create')->middleware('can:manage_videos');
        Route::post('/', [VideosController::class, 'store'])->name('manage.store')->middleware('can:manage_videos');
        Route::get('/{video}/edit', [VideosController::class, 'edit'])->name('manage.edit')->middleware('can:manage_videos');
        Route::put('/{video}', [VideosController::class, 'update'])->name('manage.update')->middleware('can:manage_videos');
        Route::delete('/{video}', [VideosController::class, 'destroy'])->name('manage.destroy')->middleware('can:manage_videos');
    });
});

Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
