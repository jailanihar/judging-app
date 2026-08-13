<?php

namespace Database\Factories;

use App\Models\JudgingAssignment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JudgingAssignment>
 */
class JudgingAssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'stage' => fake()->randomElement(['internal', 'external']),
            'status' => 'pending',
        ];
    }
}
