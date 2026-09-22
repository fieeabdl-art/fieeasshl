<?php

namespace App\Models;

use App\Concerns\TracksAdminAuthorship;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use TracksAdminAuthorship;

    protected $fillable = [
        'title',
        'description',
        'step',
        'is_published',
        'updated_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
