<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('role')->default('admin')->after('password');
        });

        // Admin paling lama (yang pertama dibuat) otomatis dijadikan
        // super_admin, supaya sistem role baru ini selalu punya minimal
        // 1 super admin yang bisa mengelola admin lain.
        $firstAdminId = DB::table('admins')->orderBy('created_at')->value('id');

        if ($firstAdminId) {
            DB::table('admins')->where('id', $firstAdminId)->update(['role' => 'super_admin']);
        }
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
