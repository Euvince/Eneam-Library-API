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
        $name = fake()->unique()->randomElement(['Licence', 'Master', 'Doctorat']);
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'code' => ucfirst(substr($name, 0, 1)),
            'created_by' => 'APPLICATION',
        ];
    }
}
