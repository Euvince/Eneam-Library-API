<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keyword>
 */
class KeywordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keywords = [
            'Algorithmique', 'Structures de données', 'Mathématiques',
            'Finances', 'Comptabilité', 'Logistiques', 'Transport',
            'Réseaux informatiques', 'Sécurité Réseaux', 'Cryptographie',
            'Maintenance Informatique', "Systèmes d'exploitations", 'Anglais',
            'Unified Modelisation Langage', 'Bases de données', 'Apprendre le PHP',
            'Apprendre le Python', 'Apprendre le Javascript', 'Apprendre le C++',
            'Apprendre le Ruby', 'Apprendre le JAVA', 'Découvrir ReactJS',
            'Mathématiques financières', 'Algèbre Linéaire', 'Bases des Réseaux Informatiques'
        ];

        return [
            'keyword' => fake()->unique()->randomElement($keywords),
            'created_by' => "APPLICATION",
        ];
    }
}
