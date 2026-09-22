<?php

namespace App\Models;

use App\Concerns\TracksAdminAuthorship;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'client',
    'location',
    'category',
    'start_date',
    'deadline',
    'status',
    'progress',
    'description',
    'cover_image',
    'updated_by',
])]
class Project extends Model
{
    use HasFactory, TracksAdminAuthorship;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'deadline' => 'date',
            'progress' => 'integer',
        ];
    }

    public function stages(): HasMany
    {
        return $this->hasMany(ProjectStage::class)->orderBy('sort_order');
    }
}
