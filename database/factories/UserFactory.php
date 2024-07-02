<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $hasPaid = fake()->boolean(chanceOfGettingTrue : 20);

        return [
            'matricule' => fake()->numberBetween(10000000, 99999999),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'slug' => \Illuminate\Support\Str::slug($firstname." ".$lastname),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(value : 'Baba2004'), // password
            'phone_number' => fake()->unique()->phoneNumber(),
            'birth_date' => fake()->date(),
            'sex' => fake()->randomElement(['Masculin', 'Féminin', 'Autre']),
            'has_paid' => $hasPaid,
            'has_access' => $hasPaid,
            'debt_amount' => fake()->randomFloat(min : 500, max : 2500),
            'remember_token' => Str::random(10),
            'created_by' => 'APPLICATION'
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
