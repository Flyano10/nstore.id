<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Storefront\CartController as StorefrontCartController;
use App\Http\Controllers\Storefront\CheckoutController as StorefrontCheckoutController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\OrderHistoryController;
use App\Http\Controllers\Storefront\ProductController as StorefrontProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class)->name('home');

Route::name('storefront.')->group(function () {
    Route::get('/catalog', [StorefrontProductController::class, 'index'])->name('catalog');
    Route::get('/products/{slug}', [StorefrontProductController::class, 'show'])->name('product.show');

    Route::get('/cart', [StorefrontCartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [StorefrontCartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{key}', [StorefrontCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{key}', [StorefrontCartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [StorefrontCartController::class, 'destroyAll'])->name('cart.destroyAll');

    Route::get('/checkout', [StorefrontCheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [StorefrontCheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order:order_number}', [StorefrontCheckoutController::class, 'success'])->name('checkout.success');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('orders/{order}/payment-proof', [OrderController::class, 'paymentProof'])->name('orders.payment-proof');
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->name('storefront.')->group(function () {
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order:order_number}', [OrderHistoryController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
