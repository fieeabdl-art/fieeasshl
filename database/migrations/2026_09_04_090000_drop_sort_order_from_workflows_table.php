<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The `sort_order` column was added by mistake alongside `step` and was
     * never actually written to by the admin CRUD (which only ever uses
     * `step`). Having two competing "order" columns is what caused the
     * public workflow section to always render "00" and in the wrong
     * order. We standardize on `step` as the single source of truth.
     */
    public function up(): void
    {
        if (Schema::hasColumn('workflows', 'sort_order')) {
            Schema::table('workflows', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }

    public function down(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('description');
        });
    }
};
