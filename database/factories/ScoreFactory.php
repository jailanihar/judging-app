<?php

namespace Database\Factories;

use App\Models\Criterion;
use App\Models\JudgingAssignment;
use App\Models\Score;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Score>
 */
class ScoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judging_assignment_id' => JudgingAssignment::factory(),
            'criterion_id' => Criterion::factory(),
            'score' => fake()->numberBetween(0, 5),
        ];
    }
}
