<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions = [
            'Gestion des Rôles',
            'Gestion des Cycles',
            'Gestion des Paiements',
            'Gestion des Abonnements',
            'Gestion des Utilisateurs',
            'Gestion des Secteurs et Spécialités',
        ];
        $managerPermissions = [
            'Gestion des Articles',
            'Gestion des Emprunts',
            'Gestion des Soutenances',
            'Gestion des Réservations',
            'Gestion des Commentaires',
            'Gestion des Configurations',
            'Gestion des Mémoires Soutenus',
            'Gestion des Fiches de Dépôts de Mémoires',
        ];
        $userPermissions = [
            "S'Abonner",
            'Se Connecter',
            'Créer un compte',
            'Prêter un Livre',
            'Réserver un Livre',
        ];

        $managerRole = \App\Models\Role::where('name', 'Manager')->first();
        $teacherRole = \App\Models\Role::where('name', 'Enseignant')->first();
        $adminRole = \App\Models\Role::where('name', 'Administrateur')->first();
        $externStudentRole = \App\Models\Role::where('name', 'Étudiant-Extern')->first();
        $eneamienStudentRole = \App\Models\Role::where('name', 'Étudiant-Eneamien')->first();

        $managerTypeRole = \App\Models\RoleType::where('name', 'Manager')->first();
        $teacherTypeRole = \App\Models\RoleType::where('name', 'Enseignant')->first();
        $adminTypeRole = \App\Models\RoleType::where('name', 'Administrateur')->first();
        $externStudentTypeRole = \App\Models\RoleType::where('name', 'Étudiant-Extern')->first();
        $eneamienStudentTypeRole = \App\Models\RoleType::where('name', 'Étudiant-Eneamien')->first();

        /*
            foreach ($adminPermissions as $permission) {
                \App\Models\Permission::create([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                    'type_role_id' => $adminTypeRole->id,
                ]);
                $adminRole->givePermissionTo($permission);
            }
        */

        array_walk(
            array : $adminPermissions,
            callback : function (\App\Models\Permission $permission) use($adminRole, $adminTypeRole) {
                \App\Models\Permission::create([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                    'type_role_id' => $adminTypeRole->id,
                ]);
                $adminRole->givePermissionTo($permission);
            }
        );

        array_walk(
            array : $managerPermissions,
            callback : function (\App\Models\Permission $permission) use($managerRole, $adminTypeRole) {
                \App\Models\Permission::create([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                    'type_role_id' => $adminTypeRole->id,
                ]);
                $managerRole->givePermissionTo($permission);
            }
        );

        array_walk(
            array : $teacherPermissions,
            callback : function (\App\Models\Permission $permission) use($teacherRole, $teacherTypeRole) {
                \App\Models\Permission::create([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                    'type_role_id' => $teacherTypeRole->id,
                ]);
                $teacherRole->givePermissionTo($permission);
            }
        );

    }
}
