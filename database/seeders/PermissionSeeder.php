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
        $teacherPermissions = [
            "S'Abonner",
            'Se Connecter',
            'Créer un compte',
            'Prêter un Livre',
            'Réserver un Livre',
            'Demander un Accès',
            'Consulter un Livre',
            'Déposer un Mémoire',
            'Consulter un Mémoire',
        ];
        $eneamienSutudentPermissions = [
            "S'Abonner",
            'Se Connecter',
            'Créer un compte',
            'Prêter un Livre',
            'Réserver un Livre',
            'Demander un Accès',
            'Consulter un Livre',
            'Déposer un Mémoire',
            'Consulter un Mémoire',
        ];
        $externSutudentPermissions = [
            "S'Abonner",
            'Se Connecter',
            'Créer un compte',
            'Demander un Accès',
            'Consulter un Livre',
            'Consulter un Mémoire',
        ];

        $managerRole = \App\Models\Role::where('name', 'Gestionnaire')->first();
        $teacherRole = \App\Models\Role::where('name', 'Enseignant')->first();
        $adminRole = \App\Models\Role::where('name', 'Administrateur')->first();
        $externStudentRole = \App\Models\Role::where('name', 'Étudiant-Extern')->first();
        $eneamienStudentRole = \App\Models\Role::where('name', 'Étudiant-Eneamien')->first();

        $managerTypeRole = \App\Models\RoleType::where('name', 'Gestionnaire')->first();
        $teacherTypeRole = \App\Models\RoleType::where('name', 'Enseignant')->first();
        $adminTypeRole = \App\Models\RoleType::where('name', 'Administrateur')->first();
        $externStudentTypeRole = \App\Models\RoleType::where('name', 'Étudiant-Extern')->first();
        $eneamienStudentTypeRole = \App\Models\RoleType::where('name', 'Étudiant-Eneamien')->first();

        $adminPermissionsIds = [];
        array_walk(
            array : $adminPermissions,
            callback : function (string $permission) use($adminRole, &$adminPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $adminPermissionsIds[] = $p->id;
                $adminRole->givePermissionTo($permission);
            }
        );
        $adminTypeRole->permissions()->sync($adminPermissionsIds);

        $managerPermissionsIds = [];
        array_walk(
            array : $managerPermissions,
            callback : function (string $permission) use($managerRole, &$managerPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $managerPermissionsIds[] = $p->id;
                $managerRole->givePermissionTo($permission);
            }
        );
        $managerTypeRole->permissions()->sync($managerPermissionsIds);


        $teacherPermissionsIds = [];
        array_walk(
            array : $teacherPermissions,
            callback : function (string $permission) use($teacherRole, &$teacherPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $teacherPermissionsIds[] = $p->id;
                $teacherRole->givePermissionTo($permission);
            }
        );
        $teacherTypeRole->permissions()->sync($teacherPermissionsIds);

        /* $teacherPermissionsIds = [];
        array_walk(
            array : $teacherPermissions,
            callback : function (string $permission) use($teacherRole, &$teacherPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $teacherPermissionsIds[] = $p->id;
                $teacherRole->givePermissionTo($permission);
            }
        );
        $teacherTypeRole->permissions()->sync($teacherPermissionsIds); */

    }
}
