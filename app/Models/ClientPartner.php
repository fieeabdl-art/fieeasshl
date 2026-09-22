<?php

namespace App\Models;

use App\Concerns\TracksAdminAuthorship;
use Illuminate\Database\Eloquent\Model;

class ClientPartner extends Model
{
    use TracksAdminAuthorship;

    protected $fillable = [
        'name',
        'logo',
        'type',
        'description',
        'website',
        'sort_order',
        'is_published',
        'updated_by',
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
