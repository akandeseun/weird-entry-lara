<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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
    Route::get('/me', 'me')->middleware('jwt-auth');
    Route::get('/confirm-email', 'confirmEmail')->middleware('jwt-auth');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/{id}', 'show');
        Route::post('/category', 'store');
        Route::patch('/category', 'update');
        Route::delete('/category/{id}', 'destroy');
    });
});
