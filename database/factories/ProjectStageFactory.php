<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectStage>
 */
class ProjectStageFactory extends Factory
{
    protected $model = ProjectStage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => fake()->word(),
            'status' => 'pending',
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
