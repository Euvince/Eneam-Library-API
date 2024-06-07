<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoleType>
 */
class RoleTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $elements = [
            'Enseignant',
            'Gestionnaire',
            'Administrateur',
            'Etudiant-Eneamien',
            'Etudiant-Externe'
        ];
        $name = fake()->unique()->randomElement($elements);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'created_by' => 'APPLICATION'
        ];
    }
}
