<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Payment::factory(30)->create()
            ->each(callback : function (\App\Models\Payment $payment) {
                $payment->update([
                    'user_id' => array_rand(\App\Models\User::pluck('matricule', 'id')->toArray(), 1),
                ]);
            })
        ;
    }
}
