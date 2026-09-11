<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatedDivision extends Model
{
    protected $fillable = [
        'initial',
        'color',
        'logo',
        'name',
        'description',
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
