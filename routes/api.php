<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    // Resend Verification Mail
    Route::post('/email/verification-notification', 'resendVerificationEmail')->middleware(['auth:sanctum'])->name('verification.send');

    // Verify Email
    Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->middleware(['auth:sanctum'])->name('verification.verify');
});
