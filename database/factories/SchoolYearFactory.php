<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolYear>
 */
class SchoolYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $startDate = fake()->dateTimeBetween(startDate : '-15 years', endDate : 'now');
        $endDate = (clone $startDate)->modify(modifier : '+1  year');

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'school_year' => \Carbon\Carbon::parse($startDate)->year . "-" . \Carbon\Carbon::parse($endDate)->year
        ];
    }
}
