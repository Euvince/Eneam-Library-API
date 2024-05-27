<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rising' => fake()->randomElement(['500', '1000']),
            'payment_date' => fake()->dateTimeBetween(startDate : '-3 years', endDate : 'now'),
            'created_by' => 'APPLICATION',
        ];
    }
}
