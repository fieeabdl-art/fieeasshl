<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_activities', function (Blueprint $table) {
            // Label singkat siap tampil, mis. "Chrome di Windows", "Safari di iPhone".
            $table->string('device')->nullable()->after('description');

            // User agent mentah, disimpan untuk keperluan audit/debug bila
            // suatu saat label di atas perlu diverifikasi ulang.
            $table->string('user_agent', 512)->nullable()->after('device');
        });
    }

    public function down(): void
    {
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->dropColumn(['device', 'user_agent']);
        });
    }
};
