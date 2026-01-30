<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('auth.login'));

Route::get('/auth/google', [GoogleController::class, 'redirect'])
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
    | Users Trash (Admin & Super Admin)
    */
    Route::prefix('users')->name('users.')->middleware('role:super_admin,admin')->group(function () {

        // View Trash
        Route::get('trash', [UserController::class, 'trash'])->name('trash');

        // Restore (admin bisa restore user biasa)
        Route::post('{id}/restore', [UserController::class, 'restore'])->name('restore');

        // Force delete (hanya super_admin)
        Route::delete('{id}/force-delete', [UserController::class, 'forceDelete'])
            ->name('force-delete')
            ->middleware('role:super_admin');
    });

    /*
    | Complete Profile
    */
    Route::get('/complete-profile', [ProfileController::class, 'complete'])
        ->name('profile_complete');

    Route::post('/complete-profile', [ProfileController::class, 'storeComplete'])
        ->name('profile.complete.store');

    /*
    | OTP
    */
    Route::get('/otp/verify', function () {
        return view('otp.verify');
    })->name('otp.verify.form');

    Route::post('/otp/send', [OtpController::class, 'send'])
        ->name('otp.send');

    Route::post('/otp/verify', [OtpController::class, 'verify'])
        ->name('otp.verify');

    /*
    | Change Password (SETELAH OTP)
    */
    Route::get('/change-password', function () {
        return view('auth.change-password');
    })
    ->middleware(['auth', 'otp:password_change'])
    ->name('password.form'); // ✅ GANTI NAMA

});

require __DIR__.'/auth.php';
