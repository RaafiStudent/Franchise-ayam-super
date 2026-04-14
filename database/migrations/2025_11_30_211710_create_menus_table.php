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
        
        $table->integer('loves')->default(0);    // Kolom Like
        $table->integer('dislikes')->default(0); // <--- TAMBAHKAN INI (Kolom Dislike)
        
        $table->string('badge')->nullable();
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
