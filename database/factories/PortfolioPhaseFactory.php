<?php

namespace Database\Factories;

use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioPhase>
 */
class PortfolioPhaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'portfolio_id' => Portfolio::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'percentage' => fake()->randomElement([0, 50, 100]),
            'sort_order' => 0,
        ];
    }
}
