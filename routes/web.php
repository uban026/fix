<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\User\UserCartController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserLandingController;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\User\ProductDetailsController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::get('/', [UserLandingController::class, 'index'])->name('home');
Route::get('/product', [UserLandingController::class, 'product'])->name('product');
Route::get('/about', [UserLandingController::class, 'about'])->name('about');
Route::get('/service', [UserLandingController::class, 'service'])->name('service');
Route::get('/portofolio', [UserLandingController::class, 'portofolio'])->name('portofolio');
Route::get('/detail/{slug}', [ProductDetailsController::class, 'index'])->name('detail');
Route::get('/cart', [UserCartController::class, 'index'])->name('cart');
Route::post('/check-coupon', [UserCartController::class, 'check'])->name('check.coupon');


// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->name('auth.logout')
    ->middleware('auth');

// Midtrans callback (no auth & CSRF)
Route::post('/payments/midtrans-callback', [UserCheckoutController::class, 'callback'])
    ->name('midtrans.callback')
    ->middleware('web:false');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Regular User Routes
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::patch('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');

    // Route baru untuk handle sukses pembayaran
    Route::patch('/orders/{order}/payment-success', [UserOrderController::class, 'paymentSuccess'])->name('user.orders.payment-success');

    // Checkout Routes
    Route::post('/checkout/process', [UserCheckoutController::class, 'process'])
        ->name('checkout.process');
    Route::post('/payments/update-status', [UserCheckoutController::class, 'updateStatus'])
        ->name('payment.update-status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // ... (sisa kode admin routes tidak berubah)
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Categories Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('admin.categories.index');
        Route::post('/', [CategoryController::class, 'store'])
            ->name('admin.categories.store');
        Route::put('/{category}', [CategoryController::class, 'update'])
            ->name('admin.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])
            ->name('admin.categories.destroy');
    });

    // Coupons Management
    Route::prefix('coupons')->group(function () {
        Route::get('/', [CouponController::class, 'index'])
            ->name('admin.coupons.index');
        Route::post('/', [CouponController::class, 'store'])
            ->name('admin.coupons.store');
        Route::put('/{coupon}', [CouponController::class, 'update'])
            ->name('admin.coupons.update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])
            ->name('admin.coupons.destroy');
    });

    // Products Management
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])
            ->name('admin.products.index');
        Route::post('/', [ProductController::class, 'store'])
            ->name('admin.products.store');
        Route::put('/{product}', [ProductController::class, 'update'])
            ->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])
            ->name('admin.products.destroy');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->name('admin.users.index');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('admin.users.destroy');
    });

    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrdersController::class, 'index'])
            ->name('admin.orders.index');
        Route::patch('/{order}/status', [OrdersController::class, 'updateStatus'])
            ->name('admin.orders.update-status');
    });

    // Order History
    Route::get('/history-order', [OrderHistoryController::class, 'index'])
        ->name('admin.history.index');
});
