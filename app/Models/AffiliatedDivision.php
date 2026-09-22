<?php

namespace App\Models;

use App\Concerns\TracksAdminAuthorship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliatedDivision extends Model
{
    use HasFactory, TracksAdminAuthorship;

    protected $fillable = [
        'initial',
        'color',
        'logo',
        'name',
        'description',
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
}
