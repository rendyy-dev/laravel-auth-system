<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('auth.login'));

Route::post('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| Authenticated
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | Products
    */
    Route::resource('products', ProductController::class);

    /*
    | Users (Admin & Super Admin)
    */
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:super_admin,admin');

    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active')
        ->middleware('role:super_admin,admin');

    /*
    | Users Trash (Super Admin only)
    */
    Route::prefix('users')->name('users.')->middleware('role:super_admin')->group(function () {

        Route::get('trash', [UserController::class, 'trash'])
            ->name('trash');

        Route::post('{id}/restore', [UserController::class, 'restore'])
            ->name('restore');

        Route::delete('{id}/force-delete', [UserController::class, 'force-delete'])
            ->name('force-delete');
    });

    /*
    | Complete Profile
    */
    Route::get('/complete-profile', [ProfileController::class, 'complete'])
        ->name('profile_complete');

    Route::post('/complete-profile', [ProfileController::class, 'storeComplete'])
        ->name('profile.complete.store');
});

require __DIR__.'/auth.php';
