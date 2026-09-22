<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that get a "last edited by which admin" column.
     *
     * @var list<string>
     */
    protected array $tables = [
        'services',
        'portfolios',
        'portfolio_phases',
        'testimonials',
        'faqs',
        'settings',
        'workflows',
        'team_profiles',
        'client_partners',
        'affiliated_divisions',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'updated_by')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('updated_by')
                    ->nullable()
                    ->after('updated_at')
                    ->constrained('admins')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'updated_by')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropConstrainedForeignId('updated_by');
            });
        }
    }
};
