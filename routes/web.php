<?php

use App\Http\Controllers\OccasionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MechanicMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::prefix('occasions')->name('occasions.')->group(function () {
    Route::get('/', [OccasionController::class, 'index'])->name('home');
    Route::get('/{id}', [OccasionController::class, 'view'])->name('view');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/service/create', [ServiceController::class, 'createForm'])->name('service.create');
    Route::post('/service/create', [ServiceController::class, 'store'])->name('service.store');
});


Route::get('/service/create', [ServiceController::class, 'createForm'])->name('service.create');
Route::post('/service/create', [ServiceController::class, 'store'])->name('service.store');


Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::middleware(AdminMiddleware::class, 'auth')->group(function () {
        //admin only
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('home')->name('home.')->group(function () {
            Route::get('/general', [HomeController::class, 'general'])->name('general');
            Route::put('/general', [HomeController::class, 'update'])->name('general.update');
            Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
            Route::put('/contact', [HomeController::class, 'updateContact'])->name('contact.update');
            Route::get('/time', [HomeController::class, 'time'])->name('time');
            Route::put('/time', [HomeController::class, 'updateTime'])->name('time.update');
        });
    });
    // admin and mechanic
    Route::middleware(MechanicMiddleware::class, 'auth')->group(function () {
        Route::prefix('service')->name('service.')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('index');
            Route::delete('/{car}', [ServiceController::class, 'destroy'])->name('destroy');
            Route::get('/{car}/complete', [ServiceController::class, 'markAsComplete'])->name('complete');
            Route::put('/{car}', [ServiceController::class, 'finish'])->name('finish');
        });
        Route::prefix('occasions')->name('occasions.')->group(function () {
            Route::get('/', [OccasionController::class, 'overview'])->name('index');
            Route::get('/{occasion}', [OccasionController::class, 'edit'])->name('edit');
            Route::delete('/{occasion}', [OccasionController::class, 'destroy'])->name('destroy');
            Route::put('/{occasion}', [OccasionController::class, 'update'])->name('update');
            Route::put('/{occasion}', [OccasionController::class, 'sell'])->name('sell');
        });
    });
});

require __DIR__ . '/auth.php';
