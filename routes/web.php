<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('welcome');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // POSTS
        Route::view('/posts', 'posts.index')->name('posts.index');
        Route::view('/posts/create', 'posts.create')->name('posts.create');
        Route::view('/posts/{post}/edit', 'posts.edit')->name('posts.edit')
            ->whereNumber('post');

        // SERVICES
        Route::view('/services', 'services.index')->name('services.index');
        Route::view('/services/create', 'services.create')->name('services.create');
        Route::view('/services/{service}/edit', 'services.edit')->name('services.edit')
            ->whereNumber('service');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
