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
            if (! Schema::hasColumn('settings', 'ecosystem_intro')) {
                $table->string('ecosystem_intro', 500)->nullable();
            }
            if (! Schema::hasColumn('settings', 'parent_company_name')) {
                $table->string('parent_company_name')->nullable();
            }
            if (! Schema::hasColumn('settings', 'parent_company_description')) {
                $table->text('parent_company_description')->nullable();
            }
        });

        // Nilai awal mengikuti konten yang sudah digunakan pada desain footer.
        DB::table('settings')->whereNull('ecosystem_intro')->update([
            'ecosystem_intro' => 'Satu ekosistem, beragam keahlian, terhubung dalam sinergi yang berkelanjutan.',
        ]);

        DB::table('settings')->whereNull('parent_company_name')->update([
            'parent_company_name' => 'PT Arada Integra Indonesia (Artersia)',
        ]);

        DB::table('settings')->whereNull('parent_company_description')->update([
            'parent_company_description' => 'Induk perusahaan yang menaungi berbagai divisi usaha di bidang interior, custom furniture, dan pengadaan.',
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $columns = array_filter([
                'ecosystem_intro',
                'parent_company_name',
                'parent_company_description',
            ], fn ($column) => Schema::hasColumn('settings', $column));

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
