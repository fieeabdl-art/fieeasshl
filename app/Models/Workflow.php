<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'title',
        'description',
        'step',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
