<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Hero subtitle bisa berisi deskripsi yang panjang
            $table->text('hero_subtitle')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Kembalikan ke VARCHAR 255 jika migration di-rollback
            $table->string('hero_subtitle')->nullable()->change();
        });
    }
};
