<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Models\Category;
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
    Route::get('/confirm-email', 'confirmEmail')->middleware('jwt-auth');
});

// Category Routes
// Route::controller(CategoryController::class)->group(function () {
//     Route::middleware(['jwt-auth'])->group(function () {
//     });
// });

// Category
Route::get('/category', [CategoryController::class, 'getAllCategories']);
Route::get('/category/{id}', [CategoryController::class, 'getCategory']);
Route::post('/category', [CategoryController::class, 'createCategory']);
Route::patch('/category', [CategoryController::class, 'updateCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

// Products
Route::post('/img', [ProductController::class, 'uploadImageToCloudinary']);
Route::get('/product', [ProductController::class, 'getAllProducts']);
Route::get('/product/s', [ProductController::class, 'searchProduct']);
Route::post('/product', [ProductController::class, 'createProduct']);
Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::patch('/product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);


// Sizes
Route::get('/size', [SizeController::class, 'getAllSizes']);
Route::get('/size/{id}', [SizeController::class, 'getSize']);
Route::post('/size', [SizeController::class, 'createSize']);
Route::patch('/size', [SizeController::class, 'updateSize']);
Route::delete('/size/{id}', [SizeController::class, 'deleteSize']);

// Colors
Route::get('/color', [ColorController::class, 'getAllColors']);
Route::get('/color/{id}', [ColorController::class, 'getColor']);
Route::post('/color', [ColorController::class, 'createColor']);
Route::patch('/color', [ColorController::class, 'updateColor']);
Route::delete('/color/{id}', [ColorController::class, 'deleteColor']);
