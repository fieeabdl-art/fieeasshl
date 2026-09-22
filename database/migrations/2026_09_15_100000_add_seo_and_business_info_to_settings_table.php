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
            // Nomor telepon terpisah dari WhatsApp (mis. telepon kantor/landline),
            // dipakai untuk kartu bisnis & JSON-LD "telephone".
            if (! Schema::hasColumn('settings', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('contact_whatsapp');
            }

            // URL website resmi. Informasional saja — canonical/OG/sitemap tetap
            // mengikuti APP_URL production (lihat routes/web.php), bukan field ini,
            // supaya selalu konsisten dengan domain server yang sesungguhnya.
            if (! Schema::hasColumn('settings', 'website')) {
                $table->string('website')->nullable()->after('site_name');
            }

            // SEO & Social — default title/description yang bisa diubah admin
            // tanpa edit kode (lihat SettingController & routes/web.php).
            if (! Schema::hasColumn('settings', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('website');
            }

            if (! Schema::hasColumn('settings', 'seo_description')) {
                $table->string('seo_description', 500)->nullable()->after('seo_title');
            }

            // OG Image — hasil proses otomatis (crop + resize ke 1200x630, lihat
            // App\Services\Media\SettingImageProcessor). Terpisah dari logo karena
            // rasio & tujuan penggunaannya berbeda.
            if (! Schema::hasColumn('settings', 'seo_og_image')) {
                $table->string('seo_og_image')->nullable()->after('seo_description');
            }
        });

        // Isi default untuk baris yang sudah ada (mis. baris tunggal settings
        // yang dibuat oleh Setting::current() sebelum migration ini berjalan),
        // supaya frontend tidak tiba-tiba kehilangan title/description.
        // Nama bisnis resmi: "Bumiyuji Living Interior" (sudah final & disetujui).
        // Data lain (alamat, telepon, dsb.) sengaja TIDAK diisi di sini karena
        // belum final — admin mengisinya sendiri lewat CMS.
        DB::table('settings')->whereNull('site_name')->update([
            'site_name' => 'Bumiyuji Living Interior',
        ]);

        DB::table('settings')->whereNull('seo_title')->update([
            'seo_title' => 'Bumiyuji Living Interior',
        ]);

        DB::table('settings')->whereNull('seo_description')->update([
            'seo_description' => 'Bumiyuji Living Interior menghadirkan layanan interior, arsitektur, dan konstruksi untuk mewujudkan ruang yang elegan, fungsional, dan berkualitas.',
        ]);

        DB::table('settings')->whereNull('website')->update([
            'website' => config('app.url'),
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $columns = array_filter([
                'contact_phone',
                'website',
                'seo_title',
                'seo_description',
                'seo_og_image',
            ], fn ($column) => Schema::hasColumn('settings', $column));

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
