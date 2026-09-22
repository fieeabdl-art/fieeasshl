<?php

namespace Database\Factories;

use App\Models\TeamProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamProfile>
 */
class TeamProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'image_path' => 'teams/test.jpg',
            'instagram' => fake()->userName(),
            'linkedin' => fake()->userName(),
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}
