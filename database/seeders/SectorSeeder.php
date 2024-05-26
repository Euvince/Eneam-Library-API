<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            'IG' => 'Informatique de Gestion',
            'PLAN' => 'Plannification',
            'GCO' => 'Gestion Commerciale',
            'GFC' => 'Gestion Financière et Comptable',
            'STAT' => 'Statistiques',
            'GBA' => 'Gestion des Banques et Assurance'
        ];

        array_map(callback : function ($sector, $key) {
            \App\Models\Sector::create([
                'name' => $sector,
                'acronym' => $key,
                'created_by' => 'APPLICATION',
                'updated_by' => 'APPLICATION',
                'deleted_by' => 'APPLICATION',
            ]);
        }, array : $sectors, arrays : array_keys($sectors));
    }
}
