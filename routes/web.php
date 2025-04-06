<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as ProductFront;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Admin\ReviewController;
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

// Front-end Routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/product/list', [ProductFront::class, 'list'])->name('product.list');
Route::get('/product/{id}', [ProductFront::class, 'detail'])->name('products.detail');
Route::get('/category/{id}', [HomeController::class, 'categoryProducts']);
Route::get('/products/list', [ProductFront::class, 'list'])->name('products.list');

// User Authentication Routes
Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');
Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend');

// Add to Cart Route (available to all users)
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

// Cart Routes requiring authentication
Route::group(['middleware' => ['auth', 'check.user.status']], function () {
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');

    // Payment Routes
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    
    // Order History Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    
    // User Profile Management
    Route::put('/profile/update', [OrderController::class, 'updateProfile'])->name('profile.update');
    
    // User Dashboard
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::get('admin', [AuthController::class, 'login_admin'])->name('admin.login');
Route::get('admin/logout', [AuthController::class, 'logout_admin'])->name('admin.logout');
Route::post('admin', [AuthController::class, 'auth_login_admin'])->name('admin.auth');


Route::group(['middleware' => 'admin'], function () {

    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::post('admin/dashboard/sales-by-date', [DashboardController::class, 'getSalesWithDateRange'])->name('admin.dashboard.salesByDate');
    
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/toggle-status/{id}', [AdminController::class, 'toggle_status']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
   
    Route::get('admin/category/list', [CategoryController::class, 'list']);
    Route::get('admin/category/add', [CategoryController::class, 'add']);
    Route::post('admin/category/add', [CategoryController::class, 'insert']);
    Route::get('admin/category/toggle-status/{id}', [CategoryController::class, 'toggle_status']);
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('admin/category/update/{id}', [CategoryController::class, 'update']);
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'delete']);
   
    // Product Routes
    Route::get('admin/product/list', [ProductController::class, 'list']);
    Route::get('admin/product/add', [ProductController::class, 'add']);
    Route::post('admin/product/add', [ProductController::class, 'insert']);
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('admin/product/update/{id}', [ProductController::class, 'update']);
    Route::get('admin/product/delete/{id}', [ProductController::class, 'delete']);
    Route::get('admin/product/delete-image/{product_id}/{image_index}', [ProductController::class, 'deleteImage']);
    Route::get('admin/product/trash', [ProductController::class, 'trash']);
    Route::get('admin/product/restore/{id}', [ProductController::class, 'restore']);
    Route::get('admin/product/force-delete/{id}', [ProductController::class, 'forceDelete']);
    Route::post('admin/product/import', [ProductController::class, 'import']);
    Route::get('admin/product/download-sample', [ProductController::class, 'downloadSample']);
    
    // Customer Management Routes
    Route::get('admin/customer/list', [CustomerController::class, 'list']);
    Route::get('admin/customer/toggle-status/{id}', [CustomerController::class, 'toggle_status']);
    
    // Order Management Routes
    Route::get('admin/orders/list', [App\Http\Controllers\Admin\OrderController::class, 'list'])->name('admin.orders.list');
    Route::get('admin/orders/detail/{id}', [App\Http\Controllers\Admin\OrderController::class, 'detail'])->name('admin.orders.detail');
    Route::put('admin/orders/update-status/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // Review Management Routes
    Route::get('admin/reviews/list', [ReviewController::class, 'list'])->name('admin.reviews.list');
    Route::get('admin/reviews/delete/{id}', [ReviewController::class, 'delete'])->name('admin.reviews.delete');
});

// Test route for email template preview (Remove after testing)
Route::get('/test-order-email', function () {
    $order = \App\Models\Order::with('user')->first();
    
    if (!$order) {
        return 'No orders found in the database.';
    }
    
    return new \App\Mail\OrderStatusUpdated($order, 'This is a test notification.');
})->middleware(['auth', 'admin']);

// Product Reviews
Route::post('/product/review', [ProductReviewController::class, 'store'])->name('product.review.store')->middleware(['auth', 'verified']);
Route::get('/product/reviews/more', [ProductReviewController::class, 'loadMore'])->name('product.reviews.more')->middleware(['auth', 'verified']);
Route::get('/product/reviews/unreviewed', [ProductReviewController::class, 'getUnreviewedProducts'])->name('product.reviews.unreviewed')->middleware(['auth', 'verified']);
Route::get('/product/reviews/reviewed', [ProductReviewController::class, 'getReviewedProducts'])->name('product.reviews.reviewed')->middleware(['auth', 'verified']);
Route::put('/product/review/{id}', [ProductReviewController::class, 'update'])->name('product.review.update')->middleware(['auth', 'verified']);
