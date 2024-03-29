<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Admin\Auth\ResetPasswordController;

Route::prefix('admin')->group( function() {

    // Register
    Route::post('register', [RegisterController::class, 'register']);

    // Login
    Route::post('login', [LoginController::class, 'login']);

    // Forgot Password
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);

    // Reset Password
    Route::post('reset/{email}/{token}', [ResetPasswordController::class, 'reset']);

    Route::middleware('auth:sanctum')->group( function() {
        // Route::get('users');
    });
});
