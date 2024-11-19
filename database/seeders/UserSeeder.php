<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* \App\Models\User::factory(10)->create(); */

        \App\Models\User::create([
            'lastname' => 'Doe',
            'firstname' => 'John',
            'slug' => \Illuminate\Support\Str::slug('Doe John'),
            'email' => 'john@doe.fr',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => fake()->unique()->phoneNumber(),
            'birth_date' => fake()->date(),
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])
        ->assignRole([\App\Models\Role::all()])
        ->permissions()->sync(\App\Models\Permission::all());

        $ghislaine = \App\Models\User::create([
            'lastname' => 'AKOMIA',
            'firstname' => 'Ghislaine',
            'slug' => \Illuminate\Support\Str::slug('AKOMIA Ghislaine'),
            'email' => 'ghislaine@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 65 93 20 52',
            'birth_date' => fake()->date(),
            'sex' => 'Féminin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Gestionnaire']);
        $managerPermissions = \App\Models\Role::findByName(name : 'Gestionnaire')->permissions->pluck('name', 'id');
        $adminPermissions = \App\Models\Role::findByName(name : 'Administrateur')->permissions->pluck('name', 'id');
        foreach ($managerPermissions as $permission) {
            $ghislaine->givePermissionTo($permission);
        }
        foreach ($adminPermissions as $permission) {
            $ghislaine->givePermissionTo($permission);
        }

        $euvince = \App\Models\User::create([
            'lastname' => 'CAPO-CHICHI',
            'firstname' => 'Jean-Daniel Euvince',
            'slug' => \Illuminate\Support\Str::slug('CAPO-CHICHI Jean-Daniel Euvince'),
            'email' => 'euvince03@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 96 90 90 16',
            'birth_date' => '12-12-2003',
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Administrateur']);
        $adminPermissions = \App\Models\Role::findByName(name : 'Administrateur')->permissions->pluck('name', 'id');
        foreach ($adminPermissions as $permission) {
            $euvince->givePermissionTo($permission);
        }

        $maurice = \App\Models\User::create([
            'lastname' => 'COMLAN',
            'firstname' => 'Maurice',
            'slug' => \Illuminate\Support\Str::slug('COMLAN Maurice'),
            'email' => 'maurice@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 95 34 02 36',
            'birth_date' => fake()->date(),
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Enseignant']);
        $teacherPermissions = \App\Models\Role::findByName(name : 'Enseignant')->permissions->pluck('name', 'id');
        foreach ($teacherPermissions as $permission) {
            $maurice->givePermissionTo($permission);
        }

        $charbel = \App\Models\User::create([
            'lastname' => 'BOKO',
            'firstname' => 'Charbel',
            'slug' => \Illuminate\Support\Str::slug('BOKO Charbel'),
            'email' => 'charbel@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 97 60 26 56',
            'birth_date' => fake()->date(),
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Enseignant']);
        $teacherPermissions = \App\Models\Role::findByName(name : 'Enseignant')->permissions->pluck('name', 'id');
        foreach ($teacherPermissions as $permission) {
            $charbel->givePermissionTo($permission);
        }

        $joly = \App\Models\User::create([
            'lastname' => 'LAOUROU',
            'firstname' => 'Joly-Tharcisius Adébola',
            'slug' => \Illuminate\Support\Str::slug('LAOUROU Joly-Tharcisius Adébola'),
            'email' => 'joly@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 61 66 05 92',
            'birth_date' => fake()->date(),
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Externe']);

        $externStudentPermissions = \App\Models\Role::findByName(name : 'Etudiant-Externe')->permissions->pluck('name', 'id');

        foreach ($externStudentPermissions as $permission) {
            $joly->givePermissionTo($permission);
        }

        $eneamienStudentPermissions = \App\Models\Role::findByName(name : 'Etudiant-Eneamien')->permissions->pluck('name', 'id');

        $daril = \App\Models\User::create([
            'matricule' => fake()->unique()->numberBetween(10000000, 99999999),
            'lastname' => 'DJODJO KOUTON',
            'firstname' => 'Esprit-Divin Daril',
            'slug' => \Illuminate\Support\Str::slug('DJODJO KOUTON Esprit-Divin Daril'),
            'email' => 'darkout04@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 90 50 59 73',
            'birth_date' => '30-05-2004',
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Eneamien']);
        foreach ($eneamienStudentPermissions as $permission) {
            $daril->givePermissionTo($permission);
        }

        $arthur = \App\Models\User::create([
            'matricule' => fake()->unique()->numberBetween(10000000, 99999999),
            'lastname' => 'ZANNOU',
            'firstname' => 'Marc-Arthur',
            'slug' => \Illuminate\Support\Str::slug('ZANNOU Marc-Arthur'),
            'email' => 'arthur@gmail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'phone_number' => '+229 95 55 66 94',
            'birth_date' => fake()->date(),
            'sex' => 'Masculin',
            'has_paid' => 1,
            'has_access' => 1,
            'debt_amount' => 0,
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Eneamien']);
        foreach ($eneamienStudentPermissions as $permission) {
            $arthur->givePermissionTo($permission);
        }


        $georges = \App\Models\User::create([
            'matricule' => fake()->unique()->numberBetween(10000000, 99999999),
            'lastname' => 'SAGBO',
            'firstname' => 'Georges',
            'slug' => \Illuminate\Support\Str::slug('SAGBO Georges'),
            'email' => 'georges@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Eneamien'])
        ->givePermissionTo(['Déposer un Mémoire']);

        $andre = \App\Models\User::create([
            'matricule' => fake()->unique()->numberBetween(10000000, 99999999),
            'lastname' => 'SOSSOU',
            'firstname' => 'André',
            'slug' => \Illuminate\Support\Str::slug('SOSSOU André'),
            'email' => 'andre@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Eneamien'])
        ->givePermissionTo(['Déposer un Mémoire']);

        $oswald = \App\Models\User::create([
            'lastname' => 'DOVONON',
            'firstname' => 'Oswald',
            'slug' => \Illuminate\Support\Str::slug('DOVONON Oswald'),
            'email' => 'oswald@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Externe']);

        $franklin = \App\Models\User::create([
            'lastname' => 'DUPONT',
            'firstname' => 'Franklin',
            'slug' => \Illuminate\Support\Str::slug('DUPONT Franklin'),
            'email' => 'franklin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Externe']);

        $isabelle = \App\Models\User::create([
            'lastname' => 'DOE',
            'firstname' => 'Isabelle',
            'slug' => \Illuminate\Support\Str::slug('DOE Isabelle'),
            'email' => 'isabelle@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Externe']);

        $emeline = \App\Models\User::create([
            'lastname' => 'DUBOIS',
            'firstname' => 'Emeline',
            'slug' => \Illuminate\Support\Str::slug('DUBOIS Emeline'),
            'email' => 'emeline@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Baba2004'),
            'sex' => 'Masculin',
            'has_paid' => 0,
            'has_access' => 0,
            'debt_amount' => 0,
            'created_by' => 'APPLICATION'
        ])->assignRole(['Etudiant-Externe']);

    }
}
