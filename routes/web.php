<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\{
    DashboardController,
    PostController as AdminPostController,
    CategoryController,
    TagController,
    CommentController,
    UploadController,
    YaumiActivityController,
    YaumiStreakController,
    YaumiLogController
};

// ========================================
// PUBLIC ROUTES
// ========================================

Route::get('/', fn() => redirect()->route('admin.dashboard'));

// Blog publik jika dibutuhkan
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->only(['index', 'show']);
});

// ========================================
// USER PROFILE ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// ADMIN ROUTES
// ========================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Blog Management
        Route::resource('posts', AdminPostController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('tags', TagController::class)->except(['show']);
        Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
        Route::post('/upload-image', [UploadController::class, 'store'])->name('upload-image');

        // Yaumi Management
        Route::resource('yaumi-activities', YaumiActivityController::class);
        Route::resource('yaumi-streaks', YaumiStreakController::class)->only(['index', 'show', 'destroy']);
        Route::resource('yaumi-logs', YaumiLogController::class)->only(['index', 'show', 'destroy']);
    });

require __DIR__ . '/auth.php';
