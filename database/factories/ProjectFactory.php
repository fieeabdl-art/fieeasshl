<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'client' => fake()->company(),
            'location' => fake()->city(),
            'category' => fake()->word(),
            'start_date' => now(),
            'deadline' => now()->addMonths(3),
            'status' => fake()->randomElement(['pending', 'berjalan', 'selesai', 'dibatalkan']),
            'progress' => fake()->numberBetween(0, 100),
            'description' => fake()->paragraph(),
            'cover_image' => null,
        ];
    }
}
