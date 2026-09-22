<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_login_attempts', function (Blueprint $table) {
            $table->id();

            // Dikunci per kombinasi email + IP, supaya orang lain yang
            // login dari IP yang sama dengan email berbeda tidak ikut
            // terkena lockout, dan sebaliknya.
            $table->string('identifier')->unique();

            $table->unsignedInteger('attempts')->default(0);

            // Level lockout saat ini: 0 = belum pernah terkena lockout,
            // 1 = lockout pertama (30 menit), 2 = lockout kedua (60 menit), dst.
            // Durasi berikutnya selalu 2x lipat dari level sebelumnya.
            $table->unsignedInteger('lockout_level')->default(0);

            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_login_attempts');
    }
};
