<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProductController;

//////////////////////////  User Public Routes  //////////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//////////////////////////  User Private Routes  //////////////////////////
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'showProduct']);
    Route::post('/store-product', [ProductController::class, 'storeNewProduct']);
    Route::post('/update-product/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/delete-product', [ProductController::class, 'deleteProduct']);
    Route::post('/sell-product', [ProductController::class, 'sellProduct']);
   
});
