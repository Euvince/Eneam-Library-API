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
            'Gérer les Rôles',
            'Gérer les Cycles',
            'Voir les Permissions',
            'Gérer les Utilisateurs',
            'Gérer les Secteurs et Spécialités',
        ];
        $managerPermissions = [
            'Gérer les Articles',
            'Gérer les Emprunts',
            'Gérer les Mots clés',
            'Gérer les Paiements',
            'Gérer les Abonnements',
            'Gérer les Soutenances',
            'Gérer les Réservations',
            'Voir les Commentaires',
            'Gérer les Commentaires',
            'Gérer les Notifications',
            'Gérer les Configurations',
            'Consulter les Statistiques',
            'Gérer les Années Scolaires',
            'Gérer les Mémoires Soutenus',
            'Gérer les Fiches de Dépôts de Mémoires',
        ];
        $teacherPermissions = [
            'Prêter un Livre',
            'Renouveller un Emprunt',
            'Réserver un Livre',
            'Demander un Accès',
            'Consulter un Livre',
            'Commenter un Livre',
            'Voir les Commentaires',
            'Consulter un Mémoire',
            'Télécharger un Mémoire',
            'Modifier son profile',
            'Modifier son mot de passe',
        ];
        $eneamienSutudentPermissions = [
            'Prêter un Livre',
            'Renouveller un Emprunt',
            'Réserver un Livre',
            'Demander un Accès',
            'Consulter un Livre',
            'Commenter un Livre',
            'Voir les Commentaires',
            'Déposer un Mémoire',
            'Consulter un Mémoire',
            'Télécharger un Mémoire',
            'Modifier son profile',
            'Modifier son mot de passe',
        ];
        $externSutudentPermissions = [
            'Demander un Accès',
            'Consulter un Livre',
            'Commenter un Livre',
            'Voir les Commentaires',
            'Consulter un Mémoire',
            'Télécharger un Mémoire',
            'Modifier son profile',
            'Modifier son mot de passe',
        ];

        $managerRole = \App\Models\Role::where('name', 'Gestionnaire')->first();
        $teacherRole = \App\Models\Role::where('name', 'Enseignant')->first();
        $adminRole = \App\Models\Role::where('name', 'Administrateur')->first();
        $externStudentRole = \App\Models\Role::where('name', 'Etudiant-Externe')->first();
        $eneamienStudentRole = \App\Models\Role::where('name', 'Etudiant-Eneamien')->first();

        $managerTypeRole = \App\Models\RoleType::where('name', 'Gestionnaire')->first();
        $teacherTypeRole = \App\Models\RoleType::where('name', 'Enseignant')->first();
        $adminTypeRole = \App\Models\RoleType::where('name', 'Administrateur')->first();
        $externStudentTypeRole = \App\Models\RoleType::where('name', 'Etudiant-Externe')->first();
        $eneamienStudentTypeRole = \App\Models\RoleType::where('name', 'Etudiant-Eneamien')->first();

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

        $eneamienStudentPermissionsIds = [];
        array_walk(
            array : $eneamienSutudentPermissions,
            callback : function (string $permission) use($eneamienStudentRole, &$eneamienStudentPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $eneamienStudentPermissionsIds[] = $p->id;
                $eneamienStudentRole->givePermissionTo($permission);
            }
        );
        $eneamienStudentTypeRole->permissions()->sync($eneamienStudentPermissionsIds);

        $externStudentPermissionsIds = [];
        array_walk(
            array : $externSutudentPermissions,
            callback : function (string $permission) use($externStudentRole, &$externStudentPermissionsIds) {
                $p = \App\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'slug' => \Illuminate\Support\Str::slug($permission),
                ]);
                $externStudentPermissionsIds[] = $p->id;
                $externStudentRole->givePermissionTo($permission);
            }
        );
        $externStudentTypeRole->permissions()->sync($externStudentPermissionsIds);

    }
}
