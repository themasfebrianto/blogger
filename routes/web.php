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

use App\Http\Controllers\Api\{
    CategoryController as ApiCategoryController,
    PostController as ApiPostController,
    TagController as ApiTagController,
    CommentController as ApiCommentController,
    UserController as ApiUserController,
    YaumiActivityController as ApiYaumiActivityController,
    YaumiLogController as ApiYaumiLogController,
    YaumiStreakController as ApiYaumiStreakController
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

// ========================================
// API ROUTES
// ========================================
Route::prefix('api')->name('api.')->group(function () {

    // Users
    Route::get('users', [ApiUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [ApiUserController::class, 'show'])->name('users.show');

    Route::apiResource('categories', ApiCategoryController::class);
    Route::apiResource('posts', ApiPostController::class);
    Route::apiResource('tags', ApiTagController::class);
    Route::apiResource('comments', ApiCommentController::class);
    Route::apiResource('yaumi-activities', ApiYaumiActivityController::class);
    Route::apiResource('yaumi-logs', ApiYaumiLogController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('yaumi-streaks', ApiYaumiStreakController::class)->only(['index', 'show']);
});

require __DIR__ . '/auth.php';
