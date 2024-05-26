<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cycle>
 */
class CycleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['Licence', 'Master', 'Doctorat']),
            'created_by' => 'APPLICATION',
            'updated_by' => 'APPLICATION',
            'deleted_by' => 'APPLICATION',
        ];
    }
}
