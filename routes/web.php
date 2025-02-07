<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

Route::middleware(['locale'])->group(function () {

    Route::redirect('/', 'dashboard')->name('welcome');

    Route::middleware(['auth'])->group(function () {

        Route::middleware('verified')->group(function () {

            Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

        });

        Route::get('/word', [WordController::class, 'index'])->name('word.index');
        Route::get('/word/create', [WordController::class, 'create'])->name('word.create');
        Route::post('/word', [WordController::class, 'store'])->name('word.store');
        Route::get('/word/{word:word}', [WordController::class, 'show'])->name('word.show');
        Route::get('/word/{word:word}/edit', [WordController::class, 'edit'])->name('word.edit');
        Route::put('/word/{word:word}', [WordController::class, 'update'])->name('word.update');
        Route::delete('/word/{word:word}', [WordController::class, 'destroy'])->name('word.destroy');
        Route::post('/word/import', [WordController::class, 'import'])->name('word.import');

        Route::as('account.')->group(function () {
            Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::get('/account/change-password', [PasswordController::class, 'edit'])->name('password.edit');
            Route::get('/account/change-language', [PageController::class, 'locale'])->name('locale');
        });
    });

    require __DIR__.'/auth.php';
});
