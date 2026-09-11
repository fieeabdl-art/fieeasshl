<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Keterangan baris kedua untuk alamat utama (contact_address),
            // misalnya "Kec. Citamiang, Kota Sukabumi, Jawa Barat".
            $table->string('contact_address_note')->nullable()->after('contact_address');

            // Kantor kedua (mis. "Kantor Operasional & Administrasi"),
            // sebelumnya hardcode di halaman publik.
            $table->text('secondary_address')->nullable()->after('contact_address_note');
            $table->string('secondary_address_note')->nullable()->after('secondary_address');

            // Jam operasional, sebelumnya hardcode di routes/web.php dan di Blade.
            $table->string('office_hours')->nullable()->after('secondary_address_note');
        });

        // Isi nilai default dari teks yang sebelumnya hardcode di
        // resources/views/index.blade.php, supaya tampilan halaman publik
        // tidak berubah/kosong begitu migration ini dijalankan. Admin bisa
        // langsung mengedit nilainya lewat Pengaturan Website kapan saja.
        DB::table('settings')->whereNull('contact_address_note')->update([
            'contact_address_note' => 'Kec. Citamiang, Kota Sukabumi, Jawa Barat',
            'secondary_address' => 'Jln. Ciaul Pasir Cisarua - Cikole, Jingga Residence Blok B23',
            'secondary_address_note' => 'Kota Sukabumi - Jabar 43115',
            'office_hours' => 'Senin - Sabtu (08:00 - 17:00 WIB)',
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_address_note',
                'secondary_address',
                'secondary_address_note',
                'office_hours',
            ]);
        });
    }
};
