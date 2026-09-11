<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('affiliated_divisions', function (Blueprint $table) {
            // Logo CV yang diunggah admin. Kalau kosong, tampilan akan
            // fallback ke ikon lingkaran (inisial + warna) seperti semula.
            $table->string('logo')->nullable()->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('affiliated_divisions', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
