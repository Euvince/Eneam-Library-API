<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Subscription::factory(30)->create()
            ->each(callback : function (\App\Models\Subscription $subscription) {
                $subscription->update([
                    'user_id' => array_rand(\App\Models\User::pluck('matricule', 'id')->toArray(), 1),
                ]);
            })
        ;
    }
}
