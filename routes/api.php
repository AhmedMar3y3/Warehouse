<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\BillController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CategoryCotntroller;

//////////////////////////  User Public Routes  //////////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//////////////////////////  User Private Routes  //////////////////////////
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'showProduct']);
    Route::post('/store-product', [ProductController::class, 'storeNewProduct']);
    Route::post('/update-product/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/delete-product/{product}', [ProductController::class, 'deleteProduct']);

    // Categories
    Route::get('/categories', [CategoryCotntroller::class, 'index']);
    Route::get('/categories/{category}', [CategoryCotntroller::class, 'show']);
    Route::post('/store-category', [CategoryCotntroller::class, 'store']);
    Route::delete('/delete-category/{category}', [CategoryCotntroller::class, 'destroy']);
    
    // Bills
    Route::get('/bills', [BillController::class, 'index']);
    Route::post('/create-bill', [BillController::class, 'store']);
    Route::delete('/destroy/{bill}', [BillController::class, 'destroy']);
    Route::get('/bills/{bill}', [BillController::class, 'show']);
    
});
