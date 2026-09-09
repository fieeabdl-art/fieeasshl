<?php

namespace App\Models;

use App\Enums\PortfolioCategory;
use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property PortfolioCategory $category
 * @property string|null $description
 * @property string|null $image
 * @property int $sort_order
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'title',
    'slug',
    'category',
    'description',
    'image',
    'sort_order',
    'is_published',
])]
class Portfolio extends Model
{
    /** @use HasFactory<PortfolioFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => PortfolioCategory::class,
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
    public function phases()
{
    return $this->hasMany(PortfolioPhase::class)->orderBy('sort_order');
}
}
