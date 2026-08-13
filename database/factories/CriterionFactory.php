<?php

namespace Database\Factories;

use App\Models\Criterion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Criterion>
 */
class CriterionFactory extends Factory
{
    public function definition(): array
    {
        $code = fake()->randomElement(['1.1', '1.2', '2.1', '2.2', '3.1', '3.2']);

        return [
            'code' => $code,
            'name' => fake()->sentence(4),
            'description' => fake()->sentence(),
            'weight' => fake()->randomFloat(2, 0.5, 5),
            'is_active' => true,
        ];
    }
}
