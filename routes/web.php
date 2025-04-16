<?php

use App\Http\Controllers\ApiMultimediaController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeriesManagerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersManagerController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosManagerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    Route::prefix('videos/manage')->middleware('auth')->group(function () {
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

// Rutes per ala gestió de les series
Route::middleware(['auth'])->group(function () {

    Route::prefix('series/manage')->middleware(['can:manage-series'])->group(function () {
        Route::get('/', [SeriesManagerController::class, 'index'])->name('series.manage.index');
        Route::get('/create', [SeriesManagerController::class, 'create'])->name('series.manage.create');
        Route::post('/', [SeriesManagerController::class, 'store'])->name('series.manage.store');
        Route::get('/{series}/edit', [SeriesManagerController::class, 'edit'])->name('series.manage.edit');
        Route::put('/{series}', [SeriesManagerController::class, 'update'])->name('series.manage.update');
        Route::get('/{series}/delete', [SeriesManagerController::class, 'delete'])->name('series.manage.delete');
        Route::delete('/{series}', [SeriesManagerController::class, 'destroy'])->name('series.manage.destroy');
    });

    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
});

// Ruta per veure un usuari específic
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
});

// Ruta per veure l'índex d'usuaris
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});
