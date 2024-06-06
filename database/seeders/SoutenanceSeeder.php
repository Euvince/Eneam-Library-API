<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoutenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Soutenance::factory(50)->create()
            ->each(callback : fn (\App\Models\Soutenance $soutenance) => $soutenance->update([
                    'year_id' => \App\Models\SchoolYear::all()->random(1)->first()['id']
                ])
            )
        ;
    }
}
