<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TeamProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'image_url' => $this->image_path ? Storage::url($this->image_path) : null,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'sort_order' => $this->sort_order,
        ];
    }
}
