<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AffiliatedDivisionResource extends JsonResource
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
            'initial' => $this->initial,
            'color' => $this->color,
            'logo_url' => $this->logo ? Storage::url($this->logo) : null,
            'name' => $this->name,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
        ];
    }
}
