<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
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
    Route::middleware(['jwt-auth'])->group(function () {
        Route::get('/category', 'getAllCategories');
        Route::get('/category/{id}', 'getCategory');
        Route::post('/category', 'createCategory');
        Route::patch('/category', 'updateCategory');
        Route::delete('/category/{id}', 'deleteCategory');
    });
});

Route::post('/img', [ProductController::class, 'uploadImageToCloudinary']);
Route::post('/product', [ProductController::class, 'createProduct']);
Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::get('/product', [ProductController::class, 'getAllProducts']);
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);

Route::get('/size', [SizeController::class, 'getAllSizes']);
Route::get('/size/{id}', [SizeController::class, 'getSize']);
Route::post('/size', [SizeController::class, 'createSize']);
Route::patch('/size', [SizeController::class, 'updateSize']);
Route::delete('/size/{id}', [SizeController::class, 'deleteSize']);
