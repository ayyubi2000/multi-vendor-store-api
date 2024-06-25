<?php

use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Auth\EmailVerificationCodeController;
use App\Http\Controllers\v1\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('email-verification', [EmailVerificationCodeController::class, 'sendEmailVerification']);
Route::post('check-email-verification', [EmailVerificationCodeController::class, 'checkEmailVerification']);

Route::middleware(['auth:sanctum', 'csrfTokenLog'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('check-user-token', [AuthController::class, 'checkUserToken']);
    Route::apiResource('user', UserController::class);
});

Route::get('token-status', function () {
    return 'not authorized';
})->name('token-status');
