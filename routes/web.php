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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MenuReportController;
use App\Http\Controllers\OwnerController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. HALAMAN UTAMA (Landing Page)
// =========================================================================
Route::get('/', function () {
    $menus = Menu::all(); 
    return view('welcome', compact('menus'));
});

// 2. Halaman Menunggu Persetujuan
Route::get('/menunggu-persetujuan', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

// =========================================================================
// 3. ROUTE INTERAKTIF PUBLIK (Contact, Like, Dislike)
// =========================================================================
Route::post('/contact-send', [MessageController::class, 'store'])->name('contact.send');
Route::post('/menu/{id}/love', [HomeController::class, 'toggleLove'])->name('menu.love');
Route::post('/menu/{id}/dislike', [HomeController::class, 'toggleDislike'])->name('menu.dislike');


// =========================================================================
// 4. GROUP MIDDLEWARE UTAMA (Tanpa is_active untuk sementara)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // A. ROUTE DASHBOARD (Redirect otomatis sesuai role)
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        }
        return redirect()->route('mitra.shop');
    })->name('dashboard');

    // B. KELOMPOK ROLE: OWNER
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/menus', [MenuReportController::class, 'index'])->name('reports.menus');
        Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
    });

    // C. KELOMPOK ROLE: ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/mitra/{id}/approve', [AdminController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [AdminController::class, 'reject'])->name('mitra.reject');
        
        Route::resource('products', ProductController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/menus', [MenuReportController::class, 'index'])->name('reports.menus');
        Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');

        Route::get('/orders', [AdminController::class, 'manageOrders'])->name('orders.index');
        Route::patch('/orders/{id}/ship', [AdminController::class, 'shipOrder'])->name('orders.ship');

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    // D. KELOMPOK ROLE: MITRA
    Route::middleware(['role:mitra'])->group(function () {
        Route::get('/shop', [ShopController::class, 'index'])->name('mitra.shop');
        Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/decrease/{id}', [ShopController::class, 'decreaseCart'])->name('cart.decrease');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/my-orders/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
        Route::patch('/my-orders/{id}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');
    });

    // E. ROUTE PROFILE (Bisa diakses semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. CALLBACK PAYMENT
Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);

require __DIR__.'/auth.php';