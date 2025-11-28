<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentCallbackController; // <--- PENTING: Import Controller Callback
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// 1. Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Halaman Menunggu Persetujuan
Route::get('/menunggu-persetujuan', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

// === GROUP MIDDLEWARE UTAMA (Area Wajib Login) ===
Route::middleware(['auth', 'verified', 'is_active'])->group(function () {

    // A. ROUTE DASHBOARD
    Route::get('/dashboard', function () {
        // Cek Admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // Jika Mitra, tampilkan Katalog Belanja
        return app(ShopController::class)->index();
    })->name('dashboard');

    // B. ROUTE BELANJA MITRA
    Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/decrease/{id}', [ShopController::class, 'decreaseCart'])->name('cart.decrease');

    //Riwayat Pesanan Mitra
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/my-orders/{id}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');

    // C. ROUTE CHECKOUT & PEMBAYARAN
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');

    // D. ROUTE KHUSUS ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/mitra/{id}/approve', [AdminController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [AdminController::class, 'reject'])->name('mitra.reject');
        Route::resource('products', ProductController::class);
    });

    // E. ROUTE PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === ROUTE WEBHOOK MIDTRANS (PENTING: Di Luar Middleware Auth) ===
// Jalur ini terbuka 24 jam agar Midtrans bisa kirim laporan status bayar
Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);

// File route auth bawaan Laravel Breeze
require __DIR__.'/auth.php';