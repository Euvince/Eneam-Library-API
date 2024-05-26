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
            'STAT' => 'Statistiques',
            'L' => 'Logistique',
            'MO' => 'Management des Organisations',
            'GCO' => 'Gestion Commerciale',
            'GFC' => 'Gestion Financière et Comptable',
            'GBA' => 'Gestion des Banques et Assurance',
            'GRH' => 'Gestion des Ressources Humaines'
        ];

        $specialitiesIG = [
            'AIP' => "Analyse Informatique et Programmation",
            'ARI' => "Administration des Réseaux Informatiques",
        ];
        $specialitiesPLAN = [
            'PGP' => "Planification et Gestion des Projets",
            'DLR' => "Développement Local et Régional",
            'EGE' => "Economie et Gestion de l'Environnement"
        ];
        $specialitiesSTAT = [
            'SDS' => "Statistiques Démographiques et Sociales",
            'SES' => "Statistiques Economiques et Sectorielles",
        ];
        $specialitiesL = [
            'TL' => "Transport et Logistique",
            'TT' => "Transports Terrestres",
            'TA' => "Transports Aéroportuaires",
            'TF' => "Transports Ferroviaires",
        ];
        $specialitiesGFC = [
            'FC' => "Finances et Comptabilité"
        ];
        $specialitiesGCO = [
            'GC' => "Gestion Commerciale",
            'ACFV' => "Action Commerciale et Force de Vente",
            'CI' => "Commerce International"
        ];
        $specialitiesGBA = [
            'MF' => "Marché Financier",
            'BM' => "Banque et Micro-finance",
            'BA' => "Banque et Assurance",
        ];

        /* array_walk(array : $sectors, callback : function ($value, $key) {
            \App\Models\Sector::create([
                'name' => $value,
                'slug' => \Illuminate\Support\Str::slug($value),
                'acronym' => $key,
                'type' => 'Filière',
                'sector_id' => NULL,
            ]);
        }); */

        array_map(function ($sector, $key) {
            \App\Models\Sector::create([
                'name' => $sector,
                'slug' => \Illuminate\Support\Str::slug($sector),
                'acronym' => $key,
                'type' => 'Filière',
                'sector_id' => NULL,
            ]);
        }, $sectors, array_keys($sectors));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'IG')->first()->id,
            ]);
        }, $specialitiesIG, array_keys($specialitiesIG));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'PLAN')->first()->id,
            ]);
        }, $specialitiesPLAN, array_keys($specialitiesPLAN));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'STAT')->first()->id,
            ]);
        }, $specialitiesSTAT, array_keys($specialitiesSTAT));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'L')->first()->id,
            ]);
        }, $specialitiesL, array_keys($specialitiesL));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GFC')->first()->id,
            ]);
        }, $specialitiesGFC, array_keys($specialitiesGFC));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GCO')->first()->id,
            ]);
        }, $specialitiesGCO, array_keys($specialitiesGCO));

        array_map(function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'slug' => \Illuminate\Support\Str::slug($speciality),
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GBA')->first()->id,
            ]);
        }, $specialitiesGBA, array_keys($specialitiesGBA));

        foreach (\App\Models\Sector::all() as  $sector) {
            $sector->update(attributes : [
                'created_by' => 'APPLICATION',
            ]);
        }

    }
}
