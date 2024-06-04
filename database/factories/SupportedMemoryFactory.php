<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportedMemory>
 */
class SupportedMemoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $theme = fake()->sentence();
        $start_at = fake()->time(format : 'H:i');
        $ends_at = \Carbon\Carbon::createFromFormat('H:i', $start_at)->addHours(rand(1, 2));

        return [
            'theme' => $theme,
            'slug' => \Illuminate\Support\Str::slug($theme),
            'start_at' => $start_at,
            'ends_at' => $ends_at,
            'first_author_matricule' => fake()->numberBetween(10000000, 99999999),
            'second_author_matricule' => fake()->numberBetween(10000000, 99999999),
            'first_author_firstname' => fake()->firstName(),
            'second_author_firstname' => fake()->firstName(),
            'first_author_lastname' => fake()->lastName(),
            'second_author_lastname' => fake()->lastName(),
            'first_author_email' => fake()->unique()->email(),
            'second_author_email' => fake()->unique()->email(),
            'first_author_phone' => fake()->unique()->phoneNumber(),
            'second_author_phone' => fake()->unique()->phoneNumber(),
            'jury_president_name' => fake()->name(),
            'memory_master_name' => fake()->name(),
            'memory_master_email' => fake()->unique()->email(),
            'created_by' => 'APPLICATION'
        ];
    }
}
