<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,svg', 'max:15360'],
            'remove_logo' => ['nullable', 'boolean'],

            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'hero_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
            'remove_hero_image' => ['nullable', 'boolean'],

            'about_title' => ['nullable', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_vision' => ['nullable', 'string'],
            'about_mission' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
            'remove_about_image' => ['nullable', 'boolean'],

            'contact_whatsapp' => ['nullable', 'string', 'max:30'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_address' => ['nullable', 'string'],
            'contact_address_note' => ['nullable', 'string', 'max:255'],
            'secondary_address' => ['nullable', 'string'],
            'secondary_address_note' => ['nullable', 'string', 'max:255'],
            'office_hours' => ['nullable', 'string', 'max:255'],
            'contact_maps_url' => ['nullable', 'url', 'max:500'],

            'social_instagram' => ['nullable', 'url', 'max:500'],
            'social_facebook' => ['nullable', 'url', 'max:500'],
            'social_tiktok' => ['nullable', 'url', 'max:500'],
            'social_youtube' => ['nullable', 'url', 'max:500'],

            'appointment_whatsapp_number' => ['nullable', 'string', 'max:30'],
            'appointment_message_template' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, jpg, png, webp, atau svg.',
            'logo.max' => 'Ukuran logo maksimal 15 MB.',
            'hero_image.image' => 'File hero harus berupa gambar.',
            'hero_image.mimes' => 'Format gambar hero harus jpeg, jpg, png, atau webp.',
            'hero_image.max' => 'Ukuran gambar hero maksimal 15MB.',
            'about_image.image' => 'File tentang kami harus berupa gambar.',
            'about_image.mimes' => 'Format gambar tentang kami harus jpeg, jpg, png, atau webp.',
            'about_image.max' => 'Ukuran gambar tentang kami maksimal 15MB.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'contact_maps_url.url' => 'URL Google Maps tidak valid.',
            'social_instagram.url' => 'URL Instagram tidak valid.',
            'social_facebook.url' => 'URL Facebook tidak valid.',
            'social_tiktok.url' => 'URL TikTok tidak valid.',
            'social_youtube.url' => 'URL YouTube tidak valid.',
        ];
    }
}
