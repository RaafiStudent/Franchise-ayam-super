<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Update kolom role agar mendukung 'owner'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mitra', 'owner') DEFAULT 'mitra'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mitra') DEFAULT 'mitra'");
    }
};