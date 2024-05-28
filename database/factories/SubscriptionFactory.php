<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subscriptionDate = fake()->dateTimeBetween(startDate : '-3 years', endDate : 'now');
        $expirationDate = (clone $subscriptionDate)->modify(
            modifier : '+' . \App\Models\Configuration::getApplicationConfiguration()->subscription_expiration_delay . ' years'
        );

        return [
            'amount' => fake()->randomElement(['500', '1000']),
            'subscription_date' => $subscriptionDate,
            'expiration_date' => $expirationDate,
            'created_by' => 'APPLICATION',
        ];
    }
}
