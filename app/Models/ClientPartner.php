<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPartner extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'type',
        'description',
        'website',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function isClient(): bool
    {
        return $this->type === 'client';
    }

    public function isPartner(): bool
    {
        return $this->type === 'partner';
    }
}
