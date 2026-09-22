<?php

namespace App\Models;

use App\Concerns\TracksAdminAuthorship;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $logo
 * @property string|null $favicon
 * @property string|null $site_name
 * @property string|null $hero_title
 * @property string|null $hero_subtitle
 * @property string|null $hero_image
 * @property string|null $about_title
 * @property string|null $about_description
 * @property string|null $about_vision
 * @property string|null $about_mission
 * @property string|null $about_image
 * @property string|null $about_video
 * @property string|null $parent_company_name
 * @property string|null $parent_company_brand
 * @property string|null $ecosystem_intro
 * @property string|null $parent_company_logo
 * @property string|null $contact_whatsapp
 * @property string|null $contact_email
 * @property string|null $contact_address
 * @property string|null $contact_address_note
 * @property string|null $secondary_address
 * @property string|null $secondary_address_note
 * @property string|null $office_hours
 * @property string|null $contact_maps_url
 * @property array<string, string>|null $social_links
 * @property string|null $appointment_whatsapp_number
 * @property string|null $appointment_message_template
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'logo',
    'favicon',
    'site_name',
    'hero_title',
    'hero_subtitle',
    'hero_image',
    'about_title',
    'about_description',
    'about_vision',
    'about_mission',
    'about_image',
    'about_video',
    'parent_company_name',
    'parent_company_brand',
    'ecosystem_intro',
    'parent_company_logo',
    'contact_whatsapp',
    'contact_email',
    'contact_address',
    'contact_address_note',
    'secondary_address',
    'secondary_address_note',
    'office_hours',
    'contact_maps_url',
    'social_links',
    'appointment_whatsapp_number',
    'appointment_message_template',
    'updated_by',
])]
class Setting extends Model
{
    use TracksAdminAuthorship;

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
