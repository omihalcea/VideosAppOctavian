<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersManagerController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosManagerController;
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

// Grup de rutes protegides per autenticació i permisos per a la gestió de vídeos
Route::middleware(['auth'])->group(function () {
    Route::prefix('videos/manage')->middleware('can:manage_videos')->group(function () {
        Route::get('/', [VideosManagerController::class, 'index'])->name('manage.index');
        Route::get('/create', [VideosManagerController::class, 'create'])->name('manage.create');
        Route::post('/', [VideosManagerController::class, 'store'])->name('manage.store');
        Route::get('/{video}/edit', [VideosManagerController::class, 'edit'])->name('manage.edit');
        Route::get('/{video}/delete', [VideosManagerController::class, 'delete'])->name('manage.delete');
        Route::put('/{video}', [VideosManagerController::class, 'update'])->name('manage.update');
        Route::delete('/{video}', [VideosManagerController::class, 'destroy'])->name('manage.destroy');
    });
});

Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');

// Rutes per la gestió d'usuaris
Route::middleware(['auth'])->group(function () {
    Route::prefix('users/manage')->middleware('can:manage-users')->group(function () {
        Route::get('/', [UsersManagerController::class, 'index'])->name('users.manage.index');
        Route::get('/create', [UsersManagerController::class, 'create'])->name('users.create');
        Route::post('/', [UsersManagerController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UsersManagerController::class, 'edit'])->name('users.edit');
        Route::get('/{user}/delete', [UsersManagerController::class, 'delete'])->name('users.delete');
        Route::put('/{user}', [UsersManagerController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UsersManagerController::class, 'destroy'])->name('users.destroy');
    });
});

// Ruta per veure un usuari específic
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
});

// Ruta per veure l'índex d'usuaris
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});
