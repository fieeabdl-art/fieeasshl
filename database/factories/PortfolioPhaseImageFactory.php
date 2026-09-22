<?php

namespace Database\Factories;

use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioPhaseImage>
 */
class PortfolioPhaseImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portfolio_phase_id' => PortfolioPhase::factory(),
            'image' => 'phases/test.jpg',
            'sort_order' => 0,
        ];
    }
}
