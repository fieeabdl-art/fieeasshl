<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Sesuaikan nama tabel 'settings' di bawah ini
     * jika nama tabel pengaturan website Anda berbeda.
     */
    public function up(): void
    {
        if (Schema::hasColumn('settings', 'about_video')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            // Path file video (disimpan di storage, bukan isi file-nya)
            $table->string('about_video')->nullable()->after('about_image');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('settings', 'about_video')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('about_video');
        });
    }
};
