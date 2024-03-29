<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Auth\Register;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Auth\ForgotPassword;
use App\Livewire\Admin\Auth\ResetPassword;
use App\Livewire\Admin\Auth\Logout;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User\UserList;

// if route is /admin redirect to admin/dashboard

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {

        // Register
        Route::get('register', Register::class)->name('register');

        // Login
        Route::get('login', Login::class)->name('login');

        // Forgot Password
        Route::get('forgot-password', ForgotPassword::class)->name('forgot.password');

        // Reset Password
        Route::get('reset/{email}/{token}', ResetPassword::class)->name('password.reset');
    });

    Route::middleware('auth:admin')->group(function () {

        // Logout
        Route::get('logout', Logout::class)->name('logout');

        // Dashboard
        Route::get('dashboard', Dashboard::class)->name('dashboard');

        // Users
        Route::get('users', UserList::class)->name('users');
    });
});
