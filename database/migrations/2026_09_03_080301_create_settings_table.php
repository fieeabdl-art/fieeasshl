<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Hero section
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            // Tentang Kami section
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->text('about_vision')->nullable();
            $table->text('about_mission')->nullable();
            $table->string('about_image')->nullable();

            // Kontak section
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('contact_maps_url')->nullable();

            // Social media (extensible key-value, e.g. {"instagram":"...","tiktok":"..."})
            $table->json('social_links')->nullable();

            // Appointment / booking via WhatsApp
            $table->string('appointment_whatsapp_number')->nullable();
            $table->text('appointment_message_template')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
