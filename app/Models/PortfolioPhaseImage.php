<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioPhaseImage extends Model
{
    protected $fillable = [
        'portfolio_phase_id',
        'image',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function phase()
    {
        return $this->belongsTo(PortfolioPhase::class, 'portfolio_phase_id');
    }
}
