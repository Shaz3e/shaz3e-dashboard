<?php

use Illuminate\Support\Facades\Route;
// Authentication Routes
use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\Auth\RegisterController;
use App\Http\Controllers\Api\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Admin\Auth\ResetPasswordController;

// Users
use App\Http\Controllers\Api\Admin\UserController;

Route::prefix('admin')->group(function () {

    // Register
    Route::post('register', [RegisterController::class, 'register']);

    // Login
    Route::post('login', [LoginController::class, 'login']);

    // Forgot Password
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);

    // Reset Password
    Route::post('reset/{email}/{token}', [ResetPasswordController::class, 'reset']);

    Route::middleware('auth:sanctum')->group(function () {

        // Users
        Route::apiResource('users', UserController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });
});
