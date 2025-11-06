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
        // LIST (tabel saja)
        Route::view('/posts', 'posts.index')->name('posts.index');

        // CREATE (form)
        Route::view('/posts/create', 'posts.create')->name('posts.create');

        // EDIT (form) — pakai route parameter {post}
        Route::view('/posts/{post}/edit', 'posts.edit')->name('posts.edit')
            ->whereNumber('post');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
