<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamProfile extends Model
{
    protected $fillable = [
        'name',
        'position',
        'image_path',
        'instagram',
        'linkedin',
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
}
