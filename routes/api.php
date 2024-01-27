<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WishlistController;
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
// ToDo: REFACTOR ROUTES into prefixes and groups
// ToDo: Protect Routes after testing

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/admin/register', 'adminRegister');
    Route::post('/login', 'login');
    Route::post('/admin/login', 'adminLogin');
    Route::get('/confirm-email', 'confirmEmail')->middleware(['jwt-auth']);
    Route::post('/logout', 'logout')->middleware(['jwt-auth']);
});

// Category
Route::get('/category', [CategoryController::class, 'getAllCategories']);
Route::get('/category/{id}', [CategoryController::class, 'getCategory']);
Route::post('/category', [CategoryController::class, 'createCategory']);
Route::patch('/category', [CategoryController::class, 'updateCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

// Products
Route::post('/img', [ProductController::class, 'uploadImageToCloudinary']);
Route::get('/product', [ProductController::class, 'getAllProducts']);
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

// Cart
Route::post('/cart/create', [CartController::class, 'updateCart']);
Route::get('/cart/f', [CartController::class, 'getUserCart']);
Route::get('/cart', [CartController::class, 'currentUserCart'])->middleware(['jwt-auth']);

// Wishlists
Route::post('/wishlist/create', [WishlistController::class, 'addToWishlist'])->middleware(['jwt-auth']);
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->middleware(['jwt-auth']);
Route::get('/wishlist', [WishlistController::class, 'getCurrentUserWishlist']);

// Orders
Route::post('/order/create', [OrderController::class, 'create']);
Route::get('/order', [OrderController::class, 'getAllOrders']);
Route::get('/order/{idOrRef}', [OrderController::class, 'getOrder']);
Route::post('/order/{idOrRef}/status', [OrderController::class, 'updateOrderStatus']);


// webhooks
Route::post('/paystack-webhook', [OrderController::class, 'paystackWebhook']);

// Transactions

Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);
Route::get('/transactions/total', [TransactionController::class, 'getTotalTransactions']);
