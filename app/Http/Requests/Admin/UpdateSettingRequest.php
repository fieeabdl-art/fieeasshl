<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_name' => ['nullable', 'string', 'max:255'],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp,svg',
                'max:15360',
            ],

            'remove_logo' => ['nullable', 'boolean'],

            'favicon' => [
                'nullable',
                'file',
                'mimes:svg,png,ico,jpg,jpeg,webp',
                'max:2048',
            ],

            'remove_favicon' => ['nullable', 'boolean'],

            'hero_title' => ['nullable', 'string', 'max:255'],

            'hero_subtitle' => ['nullable', 'string', 'max:500'],

            'hero_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:15360',
            ],

            'remove_hero_image' => ['nullable', 'boolean'],

            'about_title' => ['nullable', 'string', 'max:255'],

            'about_description' => ['nullable', 'string'],

            'about_vision' => ['nullable', 'string'],

            'about_mission' => ['nullable', 'string'],

            'about_image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:15360',
            ],

            'remove_about_image' => ['nullable', 'boolean'],

            'about_video' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/webm,video/quicktime',
                'max:51200',
            ],

            'remove_about_video' => ['nullable', 'boolean'],

            'parent_company_name' => ['nullable', 'string', 'max:255'],

            'parent_company_brand' => ['nullable', 'string', 'max:255'],

            'ecosystem_intro' => ['nullable', 'string', 'max:1000'],

            'parent_company_logo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp,svg',
                'max:15360',
            ],

            'remove_parent_company_logo' => ['nullable', 'boolean'],

            'contact_whatsapp' => ['nullable', 'string', 'max:255'],

            'contact_phone' => ['nullable', 'string', 'max:255'],

            'contact_email' => ['nullable', 'email', 'max:255'],

            'contact_address' => ['nullable', 'string'],

            'contact_address_note' => ['nullable', 'string'],

            'secondary_address' => ['nullable', 'string'],

            'secondary_address_note' => ['nullable', 'string'],

            'office_hours' => ['nullable', 'string'],

            'contact_maps_url' => ['nullable', 'url', 'max:2048'],

            'social_instagram' => ['nullable', 'url', 'max:2048'],

            'social_facebook' => ['nullable', 'url', 'max:2048'],

            'social_tiktok' => ['nullable', 'url', 'max:2048'],

            'social_youtube' => ['nullable', 'url', 'max:2048'],

            'appointment_whatsapp_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'appointment_message_template' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus JPEG, JPG, PNG, WEBP, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 15 MB.',

            'favicon.mimes' => 'Format favicon harus SVG, PNG, ICO, JPG, JPEG, atau WEBP.',
            'favicon.max' => 'Ukuran favicon maksimal 2 MB.',

            'hero_image.image' => 'File hero harus berupa gambar.',
            'hero_image.mimes' => 'Format gambar hero harus JPEG, JPG, PNG, atau WEBP.',
            'hero_image.max' => 'Ukuran gambar hero maksimal 15 MB.',

            'about_image.image' => 'File gambar tentang kami harus berupa gambar.',
            'about_image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'about_image.max' => 'Ukuran gambar maksimal 15 MB.',

            'about_video.mimetypes' => 'Format video harus MP4, WEBM, atau MOV.',
            'about_video.max' => 'Ukuran video maksimal 50 MB.',

            'parent_company_logo.image' => 'File logo perusahaan induk harus berupa gambar.',
            'parent_company_logo.mimes' => 'Format logo harus JPEG, JPG, PNG, WEBP, atau SVG.',
            'parent_company_logo.max' => 'Ukuran logo maksimal 15 MB.',

            'contact_email.email' => 'Format email tidak valid.',

            'contact_maps_url.url' => 'URL Google Maps tidak valid.',

            'social_instagram.url' => 'URL Instagram tidak valid.',
            'social_facebook.url' => 'URL Facebook tidak valid.',
            'social_tiktok.url' => 'URL TikTok tidak valid.',
            'social_youtube.url' => 'URL YouTube tidak valid.',
        ];
    }
}
