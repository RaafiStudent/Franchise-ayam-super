<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa pelakunya
            $table->string('action');      // Jenis aksi (Create/Update/Delete/Reset)
            $table->string('target_user'); // Nama/Email user yang menjadi target
            $table->text('description')->nullable(); // Detail tambahan
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('activity_logs');
    }
};