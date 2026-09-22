<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan field untuk header "Corporate Ecosystem" yang tampil
     * di atas daftar Divisi Terafiliasi pada footer:
     * - Nama perusahaan induk (mis. "PT Arada Integra Indonesia")
     * - Brand/alias perusahaan induk (mis. "Artersia")
     * - Teks intro ekosistem
     * - Logo perusahaan induk
     *
     * Migration ini murni additive: tidak mengubah/menghapus kolom lain
     * dan tidak menyentuh data existing.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'parent_company_name')) {
                $table->string('parent_company_name')->nullable()->after('about_mission');
            }

            if (! Schema::hasColumn('settings', 'parent_company_brand')) {
                $table->string('parent_company_brand')->nullable()->after('parent_company_name');
            }

            if (! Schema::hasColumn('settings', 'ecosystem_intro')) {
                $table->text('ecosystem_intro')->nullable()->after('parent_company_brand');
            }

            if (! Schema::hasColumn('settings', 'parent_company_logo')) {
                $table->string('parent_company_logo')->nullable()->after('ecosystem_intro');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            foreach ([
                'parent_company_name',
                'parent_company_brand',
                'ecosystem_intro',
                'parent_company_logo',
            ] as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
