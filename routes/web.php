<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController; // <--- PENTING: Tambahkan ini biar ga error
use Illuminate\Support\Facades\Route;

// 1. Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// 2. Halaman Menunggu Persetujuan
Route::get('/menunggu-persetujuan', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

// === GROUP MIDDLEWARE UTAMA ===
Route::middleware(['auth', 'verified', 'is_active'])->group(function () {

    // A. ROUTE DASHBOARD (PINTU GERBANG UTAMA)
    Route::get('/dashboard', function () {
        
        // 1. Cek: Apakah dia Admin?
        if (auth()->user()->role === 'admin') {
            // Jika Admin, lempar ke Dashboard Khusus Admin
            return redirect()->route('admin.dashboard');
        }

        // 2. Jika Mitra:
        // Panggil ShopController untuk ambil data Produk & Keranjang
        // Lalu tampilkan halaman belanja
        return app(ShopController::class)->index();

    })->name('dashboard');


    // B. ROUTE KERANJANG BELANJA (CART) - BARU DITAMBAHKAN
    // Ini jalur untuk tombol (+) dan (-)
    Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/decrease/{id}', [ShopController::class, 'decreaseCart'])->name('cart.decrease');


    // C. ROUTE KHUSUS ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        // Approval Mitra
        Route::patch('/mitra/{id}/approve', [AdminController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [AdminController::class, 'reject'])->name('mitra.reject');
        // Manajemen Produk
        Route::resource('products', ProductController::class);
    });

    // D. ROUTE PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';