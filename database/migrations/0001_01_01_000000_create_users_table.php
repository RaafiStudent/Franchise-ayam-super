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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        
        // --- MODIFIKASI AYAM SUPER ---
        // Role: 'admin' (Pusat) atau 'mitra' (Cabang)
        $table->enum('role', ['admin', 'mitra'])->default('mitra'); 
        
        // Status Akun: 'pending' (belum di-acc), 'active' (boleh login), 'banned' (dibekukan)
        $table->enum('status', ['active', 'pending', 'banned'])->default('pending');
        
        // Biodata Lengkap Mitra
        $table->string('no_hp')->nullable();
        $table->text('alamat_lengkap')->nullable();
        $table->string('kota')->nullable(); // Dari API Wilayah nanti
        $table->string('provinsi')->nullable(); // Dari API Wilayah nanti
        $table->string('ktp_image')->nullable(); // Path foto KTP
        $table->text('catatan')->nullable();
        // -----------------------------

        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
