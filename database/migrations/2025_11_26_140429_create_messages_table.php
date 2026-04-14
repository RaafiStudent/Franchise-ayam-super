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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        
        // Data Pengirim (Sesuai Form Contact.blade.php kamu)
        $table->string('name');    // Nama Lengkap
        $table->string('contact'); // Email / No HP
        $table->text('message');   // Isi Pesan/Saran
        
        // Status (Agar Admin tau mana yang sudah dibaca)
        $table->boolean('is_read')->default(false); 
        
        $table->timestamps(); // Mencatat kapan pesan dikirim
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
