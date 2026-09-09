<?php

namespace Database\Factories;

use App\Enums\PortfolioCategory;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'category' => fake()->randomElement(PortfolioCategory::cases())->value,
            'description' => fake()->paragraph(),
            'image' => null,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
