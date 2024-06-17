<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportedMemorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SupportedMemory::factory(150)
            ->create()
            ->each(callback : function (\App\Models\SupportedMemory $sm) {
                $soutenance = \App\Models\Soutenance::all()->random();
                $sm->update([
                    'sector_id' => array_rand(\App\Models\Sector::whereNotNull('sector_id')->pluck('acronym', 'id')->toArray(), 1),
                    'soutenance_id' => $soutenance->id,
                ]);
                /* $sm->update([
                    'cote' => \Carbon\Carbon::parse($soutenance->start_date)->year."/".$sm->sector->acronym."/".$sm->id
                ]); */
            })
        ;
    }
}
