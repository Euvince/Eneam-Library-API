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
                'acronym' => $key,
                'type' => 'Filière',
                'sector_id' => NULL,
            ]);
        }); */

        array_map(callback : function ($sector, $key) {
            \App\Models\Sector::create([
                'name' => $sector,
                'acronym' => $key,
                'type' => 'Filière',
                'sector_id' => NULL,
            ]);
        }, array : $sectors, arrays : array_keys($sectors));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'IG')->first()->id,
            ]);
        }, array : $specialitiesIG, arrays : array_keys($specialitiesIG));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'PLAN')->first()->id,
            ]);
        }, array : $specialitiesPLAN, arrays : array_keys($specialitiesPLAN));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'STAT')->first()->id,
            ]);
        }, array : $specialitiesSTAT, arrays : array_keys($specialitiesSTAT));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'L')->first()->id,
            ]);
        }, array : $specialitiesL, arrays : array_keys($specialitiesL));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GFC')->first()->id,
            ]);
        }, array : $specialitiesGFC, arrays : array_keys($specialitiesGFC));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GCO')->first()->id,
            ]);
        }, array : $specialitiesGCO, arrays : array_keys($specialitiesGCO));

        array_map(callback : function ($speciality, $key) {
            \App\Models\Sector::create([
                'name' => $speciality,
                'acronym' => $key,
                'type' => 'Spécialité',
                'sector_id' => \App\Models\Sector::where('acronym', 'GBA')->first()->id,
            ]);
        }, array : $specialitiesGBA, arrays : array_keys($specialitiesGBA));

        foreach (\App\Models\Sector::all() as  $sector) {
            $sector->update(attributes : [
                'created_by' => 'APPLICATION',
                'updated_by' => 'APPLICATION',
                'deleted_by' => 'APPLICATION',
            ]);
        }

    }
}
