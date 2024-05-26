<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soutenance>
 */
class SoutenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->year(),
            'start_date' => fake()->dateTimeBetween(startDate : '-15 years', endDate : 'now'),
            'end_date' => fake()->dateTimeBetween(),
            'number_memories_expected' => rand(min : 50, max : 250),
            'created_by' => 'APPLICATION',
            'updated_by' => 'APPLICATION',
            'deleted_by' => 'APPLICATION',
        ];
    }
}
