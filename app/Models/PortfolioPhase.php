<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioPhase extends Model
{
    /**
     * Fixed progress stages. Every portfolio has exactly these three
     * phases, identified by percentage. No free-form phases are allowed.
     */
    public const FIXED_PHASES = [
        0 => 'Dokumentasi Sebelum Proyek',
        50 => 'Proses Pengerjaan',
        100 => 'Hasil Akhir',
    ];

    /**
     * Make sure a portfolio has exactly one phase per fixed percentage
     * (0, 50, 100). Missing phases are created with empty content.
     * Existing duplicate phases (more than one row for the same
     * percentage) are never auto-deleted — the caller can inspect the
     * returned counts to surface a warning for manual review.
     *
     * @return array<int, int> map of percentage => count, only for percentages with duplicates
     */
    public static function ensureForPortfolio(Portfolio $portfolio): array
    {
        $existing = $portfolio->phases()->get();
        $counts = $existing->countBy('percentage');

        $order = 0;
        foreach (self::FIXED_PHASES as $percentage => $defaultTitle) {
            if (! $existing->contains('percentage', $percentage)) {
                $portfolio->phases()->create([
                    'title' => $defaultTitle,
                    'description' => null,
                    'percentage' => $percentage,
                    'sort_order' => $order,
                ]);
            }
            $order++;
        }

        return $counts->filter(fn ($count) => $count > 1)->all();
    }

    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
        'percentage',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Progress gallery images for this phase, ordered for display.
     */
    public function images()
    {
        return $this->hasMany(PortfolioPhaseImage::class)->orderBy('sort_order');
    }
}
