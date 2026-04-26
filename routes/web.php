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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

// ==========================
// 1. HALAMAN PUBLIK
// ==========================
Route::get('/', function () {
    $menus = Menu::all();
    return view('welcome', compact('menus'));
});

Route::get('/menunggu-persetujuan', function () {
    return view('auth.approval-notice');
})->name('approval.notice');

Route::post('/contact-send', [MessageController::class, 'store'])->name('contact.send');
Route::post('/menu/{id}/love', [HomeController::class, 'toggleLove'])->name('menu.love');
Route::post('/menu/{id}/dislike', [HomeController::class, 'toggleDislike'])->name('menu.dislike');


// ==========================
// 2. AREA WAJIB LOGIN (Terproteksi Middleware)
// ==========================
Route::middleware(['auth', 'verified', 'is_active'])->group(function () {
    
    // A. REDIRECT DASHBOARD UTAMA Berdasarkan Role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        }
        return redirect()->route('mitra.shop');
    })->name('dashboard');

    // B. GRUP ROLE: ADMIN (Full Access)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('users', UserManagementController::class);
        Route::get('/audit-logs', [AdminController::class, 'viewLogs'])->name('logs');
        Route::patch('/mitra/{id}/approve', [AdminController::class, 'approve'])->name('mitra.approve');
        Route::patch('/mitra/{id}/reject', [AdminController::class, 'reject'])->name('mitra.reject');
        Route::resource('products', ProductController::class);
        Route::get('/orders', [AdminController::class, 'manageOrders'])->name('orders.index');
        Route::patch('/orders/{id}/ship', [AdminController::class, 'shipOrder'])->name('orders.ship');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/menus', [MenuReportController::class, 'index'])->name('reports.menus');
        Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    // C. GRUP ROLE: OWNER (Monitoring Khusus)
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
        Route::get('/audit-logs', [OwnerController::class, 'viewLogs'])->name('logs');
        Route::get('/reports', [OwnerController::class, 'reportIndex'])->name('reports.index');
        Route::get('/reports/menus', [OwnerController::class, 'menuReport'])->name('reports.menus');
        Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export');
    });

    // D. GRUP ROLE: MITRA (Shopping & Orders)
    Route::middleware(['role:mitra'])->group(function () {
        Route::get('/shop', [ShopController::class, 'index'])->name('mitra.shop');
        Route::post('/cart/add/{id}', [ShopController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/decrease/{id}', [ShopController::class, 'decreaseCart'])->name('cart.decrease');
        
        // =========================================================
        // FIX: Rute Hapus Tong Sampah (Anti Refresh & Mengirim JSON)
        // =========================================================
        Route::delete('/cart/remove/{id}', function($id) {
            \App\Models\Cart::where('id', $id)->where('user_id', Auth::id())->delete();
            $carts = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
            $totalPrice = 0;
            foreach($carts as $cart) { $totalPrice += $cart->product->price * $cart->quantity; }
            
            return response()->json([
                'status' => 'success',
                'total_price' => number_format($totalPrice, 0, ',', '.'),
                'total_qty' => $carts->sum('quantity')
            ]);
        })->name('cart.remove');
        // =========================================================

        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/my-orders/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
        Route::patch('/my-orders/{id}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');
    });

    // E. PROFILE & NOTIFICATION (Semua Role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/notification/read/{id}', [NotificationController::class, 'read'])->name('notification.read');
});

// ==========================
// 3. CALLBACK PEMBAYARAN
// ==========================
Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);

require __DIR__.'/auth.php';