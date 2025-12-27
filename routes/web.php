<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

Route::middleware(['auth'])->group(function () {

    // ******Dashboard route******
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');

    // ******Profile routes******
    Route::get('/user_profile', function () {
        return view('user_profile');
    })->name('user_profile');

    Route::get('/edit_profile', function () {
        return view('edit_profile');
    })->name('edit_profile');

    Route::put('/profile-update', [AuthController::class, 'updatePassword'])
        ->name('profile.update.password');

    Route::put('/profile', [AuthController::class, 'update'])
        ->name('profile.update');

    //****Logout route****
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {

    // ******Sign-up routes******
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('registerSave', [AuthController::class, 'store'])->name('registerSave');

    // ******Sign-in route******
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginSave', [AuthController::class, 'check'])->name('loginSave');

    //****Forgot Password route*****
    Route::get('/forgot', function () {
        return view('forgot');
    })->name('forgot');
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])
        ->name('password.request');

    //****Send reset email route***
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    //****RESET LINK route****
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    //****RESET PASSWORD route****
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');

    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])
        ->name('verify.email');
});
