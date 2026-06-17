<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Customer;

// ===== PUBLIC =====
Route::get('/', [Customer\HomeController::class, 'index'])->name('home');
Route::get('/menu', [Customer\HomeController::class, 'menu'])->name('menu');

// ===== REDIRECT SETELAH LOGIN =====
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// ===== CUSTOMER =====
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/cart', [Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [Customer\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [Customer\CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [Customer\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [Customer\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/profile', [Customer\ProfileController::class, 'index'])->name('customer.profile');
    Route::put('/profile', [Customer\ProfileController::class, 'update'])->name('customer.profile.update');
    Route::put('/profile/password', [Customer\ProfileController::class, 'updatePassword'])->name('customer.profile.password');
    Route::post('/promo/apply', [Customer\PromoController::class, 'apply'])->name('promo.apply');
    Route::delete('/promo/remove', [Customer\PromoController::class, 'remove'])->name('promo.remove');
    Route::post('/review', [Customer\ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}', [Customer\ReviewController::class, 'destroy'])->name('review.destroy');
});

// ===== ADMIN =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', Admin\ProductController::class);
    Route::resource('orders', Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::resource('pembayaran', Admin\PembayaranController::class)->only(['index', 'show', 'update']);
    Route::resource('histori-stok', Admin\HistoriStokController::class)->only(['index']);
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::resource('promos', Admin\PromoController::class)->except(['show']);
    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/notifications/poll', [Admin\NotificationController::class, 'poll'])->name('notifications.poll');
    Route::post('/notifications/{id}/read', [Admin\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [Admin\NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
});

require __DIR__.'/auth.php';