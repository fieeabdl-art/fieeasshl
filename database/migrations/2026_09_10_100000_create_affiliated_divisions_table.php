<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliated_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('initial', 3);
            $table->string('color', 7)->default('#2C3E35');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // Isi data awal dari yang sebelumnya hardcode di footer
        // resources/views/index.blade.php, supaya tampilan halaman publik
        // tidak berubah/kosong begitu migration ini dijalankan.
        DB::table('affiliated_divisions')->insert([
            [
                'initial' => 'A',
                'color' => '#2C3E35',
                'name' => 'CV. Afkara Putra Multimedia',
                'description' => 'IT, Networking & Pengadaan',
                'sort_order' => 1,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'initial' => 'Y',
                'color' => '#1F6F78',
                'name' => 'CV. Yuji Sabumi Perkasa',
                'description' => 'Interior, Custom Furniture',
                'sort_order' => 2,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'initial' => 'M',
                'color' => '#2C6E9E',
                'name' => 'CV. Indonesia Muda Pratama',
                'description' => 'General Contractor Konsultan Perencanaan dan Pengawasan',
                'sort_order' => 3,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliated_divisions');
    }
};
