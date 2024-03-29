<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\User\Auth\ResetPasswordController;



// Register
Route::post('register', [RegisterController::class, 'register']);

// Login
Route::post('login', [LoginController::class, 'login']);

// Forgot Password
Route::post('forgot-password', [ForgotPasswordController::class, 'forgot']);

// Reset Password
Route::post('reset/{email}/{token}', [ResetPasswordController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('users');
});
