<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\mongodbReviewController;


Route::get('/', function () {
    return view('welcome');
});

// ==============================
// Authenticated Dashboard
// ==============================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ==============================
// Admin Routes
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.product');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/order', [AdminController::class, 'orders'])->name('admin.order');
    Route::delete('/admin/order/{id}', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store']);
});
Route::post('/admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.logout');

// ==============================
// Customer Product Routes
// ==============================
Route::get('/product', [ProductController::class, 'userIndex'])->name('customer.product');
Route::get('/product_show/{product}', [ProductController::class, 'userShow'])->name('customer.product_show');

// ==============================
// Cart & Checkout Routes
// ==============================
Route::get('/customer/cart', function () {
    return view('customer.cart');
})->name('customer.cart');

Route::post('/checkout/prepare', [OrderController::class, 'prepareCheckout'])->name('checkout.prepare');

// ==============================
// Order Routes (Customer)
// ==============================
Route::get('customer/orders/create/{product}', [OrderController::class, 'create'])->name('customer.orders.create');
Route::get('/customer/orders/create', [OrderController::class, 'create'])->name('customer.orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/confirmation/{order}', [OrderController::class, 'confirmation'])->name('orders.confirmation');

// ==============================
// Payment Routes (Customer)
// ==============================
Route::get('/payment/{order}', [OrderController::class, 'showPayment'])->name('payment');
Route::post('/payment/{order}/process', [OrderController::class, 'processPayment'])->name('payment.process');
Route::get('customer/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order}', [PaymentController::class, 'store'])->name('payment.store');

// ==============================
// MongoDB Review Routes (Customer)
// ==============================
Route::get('/customer/mongodbReviews/create/{order}', [mongodbReviewController::class, 'create'])->name('customer.mongodbReviews.create');
Route::post('/customer/mongodbReviews', [mongodbReviewController::class, 'store'])->name('customer.mongodbReviews.store');
Route::get('/customer/mongodbReviews/{review}', [mongodbReviewController::class, 'show'])->name('customer.mongodbReviews.show');
Route::get('/reviews/{id}', [mongodbReviewController::class, 'show'])->name('customer.mongodbReviews.show');
Route::delete('/reviews/{id}', [mongodbReviewController::class, 'destroy'])->name('customer.mongodbReviews.destroy');
Route::put('/customer/mongodbReviews/{id}', [mongodbReviewController::class, 'update'])->name('customer.mongodbReviews.update');
Route::get('/reviews/{id}/edit', [mongodbReviewController::class, 'edit'])->name('customer.mongodbReviews.edit');

