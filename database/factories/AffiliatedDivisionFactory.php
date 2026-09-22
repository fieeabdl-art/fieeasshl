<?php

namespace Database\Factories;

use App\Models\AffiliatedDivision;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AffiliatedDivision>
 */
class AffiliatedDivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'initial' => fake()->lexify('??'),
            'color' => fake()->safeHexColor(),
            'logo' => 'divisions/test.png',
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
