<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\RoleType::where('name', 'Administrateur')->first();
        $manager = \App\Models\RoleType::where('name', 'Gestionnaire')->first();
        $teacher = \App\Models\RoleType::where('name', 'Enseignant')->first();
        $externStudent = \App\Models\RoleType::where('name', 'Étudiant-Externe')->first();
        $eneamienStudent = \App\Models\RoleType::where('name', 'Étudiant-Eneamien')->first();

        \App\Models\Role::create([
            'name' => 'Administrateur',
            'slug' => \Illuminate\Support\Str::slug('Administrateur'),
            'role_type_id' => $admin->id
        ]);
        \App\Models\Role::create([
            'name' => 'Gestionnaire',
            'slug' => \Illuminate\Support\Str::slug('Gestionnaire'),
            'role_type_id' => $manager->id
        ]);
        \App\Models\Role::create([
            'name' => 'Enseignant',
            'slug' => \Illuminate\Support\Str::slug('Enseignant'),
            'role_type_id' => $teacher->id
        ]);
        \App\Models\Role::create([
            'name' => 'Étudiant-Extern',
            'slug' => \Illuminate\Support\Str::slug('Étudiant-Externe'),
            'role_type_id' => $externStudent->id
        ]);
        \App\Models\Role::create([
            'name' => 'Étudiant-Eneamien',
            'slug' => \Illuminate\Support\Str::slug('Étudiant-Eneamien'),
            'role_type_id' => $eneamienStudent->id
        ]);
    }
}
