<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('products', ProductController::class);

    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:super_admin,admin');

    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
    ->name('users.toggle-active')
    ->middleware('role:super_admin,admin');

    Route::get('/complete-profile', [ProfileController::class, 'complete'])->name('profile_complete');
    Route::post('/complete-profile', [ProfileController::class, 'storeComplete'])->name('profile.complete.store');

});

require __DIR__.'/auth.php';
