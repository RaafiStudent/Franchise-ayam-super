<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users (Siapa yang beli?)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Info Pembayaran
        $table->decimal('total_price', 15, 2);
        $table->enum('payment_status', ['unpaid', 'paid', 'expired', 'failed'])->default('unpaid');
        $table->string('snap_token')->nullable(); // Token dari Midtrans
        
        // Info Pengiriman (Logistik Internal)
        $table->enum('order_status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
        $table->string('resi_number')->nullable(); // Bisa diisi plat nomor supir / resi
        $table->string('courier_name')->nullable(); // Nama supir internal
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
