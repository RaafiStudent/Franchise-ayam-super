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
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('description');
        $table->string('image')->nullable();
        $table->integer('loves')->default(0);  // Suka
        $table->integer('hates')->default(0);  // Gak Suka
        $table->string('badge')->nullable();   // Contoh: 'HEMAT', 'NEW'
        $table->string('badge_color')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
