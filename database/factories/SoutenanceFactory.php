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
        $numberMemoriesExpected = rand(min : 50, max : 250);
        $startDate = fake()->dateTimeBetween(startDate : '-15 years', endDate : 'now');
        $endDate = (clone $startDate)->modify(modifier : '+' . rand(min : 3, max : 5) . ' days');

        return [
            /* 'year' => fake()->year(), */
            'start_date' => $startDate,
            'end_date' => $endDate,
            'number_memories_expected' => $numberMemoriesExpected,
            'number_memories_remaining' => $numberMemoriesExpected,
            'created_by' => 'APPLICATION',
        ];
    }
}
