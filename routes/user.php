<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\User\Auth\Login;
use App\Livewire\User\Auth\Register;
use App\Livewire\User\Auth\ForgotPassword;
use App\Livewire\User\Auth\Logout;
use App\Livewire\User\Auth\ResetPassword;
use App\Livewire\User\UserDashboard;

Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', Register::class)->name('register');

    // Login
    Route::get('/login', Login::class)->name('login');

    // Forgot Password
    Route::get('/forgot-password', ForgotPassword::class)->name('forgot.password');

    // Reset Password
    Route::get('/reset/{email}/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('/logout', Logout::class)->name('logout');

    // User Dashboard
    Route::get('dashboard', UserDashboard::class)->name('dashboard');
});
