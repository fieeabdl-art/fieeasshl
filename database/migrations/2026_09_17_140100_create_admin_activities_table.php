<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();

            // Admin yang melakukan perubahan. Nullable + nama disimpan
            // terpisah supaya riwayat tetap terbaca walau akun admin
            // yang bersangkutan nantinya dihapus.
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('admin_name');

            $table->string('action'); // created | updated | deleted | logged_in | dst.
            $table->string('subject_type')->nullable(); // nama model, mis. "Portfolio"
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('description'); // teks siap tampil, mis. "menambahkan Portfolio 'Rumah A'"

            $table->timestamp('created_at')->useCurrent();
        });

        // Menyimpan kapan tiap admin terakhir membuka halaman/notifikasi,
        // dipakai untuk menghitung jumlah notifikasi "belum dibaca".
        Schema::table('admins', function (Blueprint $table) {
            $table->timestamp('activities_read_at')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('activities_read_at');
        });

        Schema::dropIfExists('admin_activities');
    }
};
