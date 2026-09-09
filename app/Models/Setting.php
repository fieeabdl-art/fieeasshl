<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $logo
 * @property string|null $site_name
 * @property string|null $hero_title
 * @property string|null $hero_subtitle
 * @property string|null $hero_image
 * @property string|null $about_title
 * @property string|null $about_description
 * @property string|null $about_vision
 * @property string|null $about_mission
 * @property string|null $about_image
 * @property string|null $contact_whatsapp
 * @property string|null $contact_email
 * @property string|null $contact_address
 * @property string|null $contact_maps_url
 * @property array<string, string>|null $social_links
 * @property string|null $appointment_whatsapp_number
 * @property string|null $appointment_message_template
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'logo',
    'site_name',
    'hero_title',
    'hero_subtitle',
    'hero_image',
    'about_title',
    'about_description',
    'about_vision',
    'about_mission',
    'about_image',
    'contact_whatsapp',
    'contact_email',
    'contact_address',
    'contact_maps_url',
    'social_links',
    'appointment_whatsapp_number',
    'appointment_message_template',
])]
class Setting extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    /**
     * Get the single settings row, creating it if it doesn't exist yet.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
