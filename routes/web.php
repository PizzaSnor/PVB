<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MechanicMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified',])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/service/create', [ServiceController::class, 'createForm'])->name('service.create');
    Route::post('/service/create', [ServiceController::class, 'store'])->name('service.store');
});

Route::middleware(AdminMiddleware::class, 'auth')->group(function () {

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('service')->name('service.')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('index');
            Route::delete('/{car}', [ServiceController::class, 'destroy'])->name('destroy');
            Route::get('/{car}/complete', [ServiceController::class, 'markAsComplete'])->name('complete');
            Route::put('/{car}', [ServiceController::class, 'finish'])->name('finish');
        });
        
    });
});

require __DIR__ . '/auth.php';
