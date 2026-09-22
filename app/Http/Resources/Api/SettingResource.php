<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'site_name' => $this->site_name,
            'logo_url' => $this->logo ? Storage::url($this->logo) : null,
            'favicon_url' => $this->favicon ? Storage::url($this->favicon) : null,
            'hero' => [
                'title' => $this->hero_title,
                'subtitle' => $this->hero_subtitle,
                'image_url' => $this->hero_image ? Storage::url($this->hero_image) : null,
            ],
            'about' => [
                'title' => $this->about_title,
                'description' => $this->about_description,
                'vision' => $this->about_vision,
                'mission' => $this->about_mission,
                'image_url' => $this->about_image ? Storage::url($this->about_image) : null,
                'video_url' => $this->about_video ? Storage::url($this->about_video) : null,
            ],
            'corporate' => [
                'parent_company_name' => $this->parent_company_name,
                'parent_company_brand' => $this->parent_company_brand,
                'ecosystem_intro' => $this->ecosystem_intro,
                'parent_company_logo_url' => $this->parent_company_logo ? Storage::url($this->parent_company_logo) : null,
            ],
            'contact' => [
                'whatsapp' => $this->contact_whatsapp,
                'email' => $this->contact_email,
                'address' => $this->contact_address,
                'address_note' => $this->contact_address_note,
                'secondary_address' => $this->secondary_address,
                'secondary_address_note' => $this->secondary_address_note,
                'office_hours' => $this->office_hours,
                'maps_url' => $this->contact_maps_url,
                'social_links' => $this->social_links,
            ],
            'appointment' => [
                'whatsapp_number' => $this->appointment_whatsapp_number,
                'message_template' => $this->appointment_message_template,
            ],
        ];
    }
}
