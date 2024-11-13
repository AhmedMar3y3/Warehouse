<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BillController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryCotntroller;
use App\Http\Controllers\Dashboard\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//////////////////////////  User Public Routes  //////////////////////////
Route::get('/register', [AuthController::class, 'loadRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.registerUser');
Route::get('/verify-email', [AuthController::class, 'loadVerifyEmail'])->name('auth.verify-email');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('auth.verify-emailUser');
Route::get('/', [AuthController::class, 'loadLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.loginUser');
Route::get('/forgot-password', [AuthController::class, 'loadForgotPassword'])->name('auth.forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-passwordUser');
Route::get('/reset-password', [AuthController::class, 'loadResetPassword'])->name('auth.reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-passwordUser');

//////////////////////////  User Private Routes  //////////////////////////
Route::group(['middleware' => ['web', 'dashboard.auth']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [HomeController::class, 'loadDashboard'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'showProduct']);
    Route::post('/store-product', [ProductController::class, 'storeNewProduct']);
    Route::post('/update-product/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/delete-product/{product}', [ProductController::class, 'deleteProduct']);
    Route::post('/sell-products/{product}', [ProductController::class, 'sellProduct']); 
    Route::post('/sell-multiple-products', [ProductController::class, 'sellMultipleProducts']);
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::post('/create-bill', [BillController::class, 'createBill']);

    // Categories
    Route::get('/categories', [CategoryCotntroller::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryCotntroller::class, 'show'])->name('categories.show');
    Route::get('/create-category', [CategoryCotntroller::class, 'create'])->name('categories.create');
    Route::post('/store-category', [CategoryCotntroller::class, 'store'])->name('categories.store');
    Route::delete('/delete-category/{category}', [CategoryCotntroller::class, 'destroy'])->name('categories.destroy');
});

