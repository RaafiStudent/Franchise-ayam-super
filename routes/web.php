<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;      // Laporan Keuangan
use App\Http\Controllers\MenuReportController;  // Laporan Menu Favorit (BARU)
use App\Models\Menu;                            // Model untuk Landing Page
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. HALAMAN UTAMA (Landing Page)
// =========================================================================
Route::get('/', function () {
    // Ambil data menu dari tabel 'menus' untuk ditampilkan di landing page
    $menus = Menu::all(); 
    
    // Kirim variable $menus ke view
    return view('welcome', compact('menus'));
});

// 2. Halaman Menunggu Persetujuan
Route::get('/menunggu-persetujuan', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

// =========================================================================
// 3. ROUTE INTERAKTIF PUBLIK (Contact, Like, Dislike)
// =========================================================================
// Kirim Pesan (Contact Us)
Route::post('/contact-send', [MessageController::class, 'store'])->name('contact.send');

// Route Like & Dislike untuk Menu (AJAX)
Route::post('/menu/{id}/love', [HomeController::class, 'toggleLove'])->name('menu.love');
Route::post('/menu/{id}/dislike', [HomeController::class, 'toggleDislike'])->name('menu.dislike');


// =========================================================================
// 4. GROUP MIDDLEWARE UTAMA (Area Wajib Login)
// =========================================================================
Route::middleware(['auth', 'verified', 'is_active'])->group(function () {

    // A. ROUTE DASHBOARD (Redirect sesuai role)
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // Jika Mitra, tampilkan Katalog Belanja
        return app(ShopController::class)->index();
    })->name('dashboard');

    // B. ROUTE BELANJA MITRA (Cart)
    Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/decrease/{id}', [ShopController::class, 'decreaseCart'])->name('cart.decrease');

    // C. ROUTE CHECKOUT & PEMBAYARAN
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');

    // D. ROUTE RIWAYAT PESANAN (MY ORDERS)
    Route::get('/my-orders/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/my-orders/{id}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');

    // E. ROUTE KHUSUS ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export');
        // Dashboard Admin & Approval Mitra
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/mitra/{id}/approve', [AdminController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [AdminController::class, 'reject'])->name('mitra.reject');
        
        // Manajemen Produk (Bahan Baku untuk Mitra)
        Route::resource('products', ProductController::class);

        // --- LAPORAN & ANALISIS ---
        // 1. Laporan Keuangan (Grafik Omset)
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        // 2. Laporan Menu Favorit (Tabel Like/Dislike) -> BARU
        Route::get('/reports/menus', [MenuReportController::class, 'index'])->name('reports.menus');

        // Manajemen Pesanan & Input Resi
        Route::get('/orders', [AdminController::class, 'manageOrders'])->name('orders.index');
        Route::patch('/orders/{id}/ship', [AdminController::class, 'shipOrder'])->name('orders.ship');

        // Manajemen Pesan Masuk (Inbox)
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    // F. ROUTE PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================================================
// 5. ROUTE WEBHOOK MIDTRANS (PENTING: Di Luar Middleware Auth)
// =========================================================================
Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);

// File route auth bawaan Laravel Breeze
require __DIR__.'/auth.php';