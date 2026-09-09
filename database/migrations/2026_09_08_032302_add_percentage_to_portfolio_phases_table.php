<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Guarded: create_portfolio_phases_table already defines this column.
        // This migration is kept for environments where it was already run,
        // but must not fail with "duplicate column" where it wasn't needed.
        if (! Schema::hasColumn('portfolio_phases', 'percentage')) {
            Schema::table('portfolio_phases', function (Blueprint $table) {
                $table->unsignedTinyInteger('percentage')
                    ->default(0)
                    ->after('description');
            });
        }
    }

    public function down(): void
    {
        // No-op: dropping this column here would also affect the column
        // defined by create_portfolio_phases_table. Handled by that
        // migration's own down() instead.
    }
};