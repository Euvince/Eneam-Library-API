<?php

namespace App\Imports;

use App\Helpers;
use App\Jobs\SendConnectionCredentialsToUserJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{

    public function __construct(
        private readonly Request $request
    )
    {
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($this->request->routeIs("import.eneamiens.students")) {
            if (in_array($row[2], User::pluck('email')->toArray())) {
                return null;
            }
            $eneamienStudentPermissions = \App\Models\Role::findByName(name : 'Etudiant-Eneamien')->permissions->pluck('name', 'id');
            $password = Helpers::generateRandomPassword();
            $user = new User([
                'email'     => $row[2],
                'lastname'  => $row[1],
                'matricule' => $row[3],
                'firstname' => $row[0],
                'password'  => Hash::make($password),
            ]);
            $user->assignRole(roles : ['Etudiant-Eneamien']);
            $user->givePermissionTo(['Déposer un Mémoire']);
            /* foreach ($eneamienStudentPermissions as $permission) {
                $user->givePermissionTo($permission);
            } */
            SendConnectionCredentialsToUserJob::dispatch($user->email, $user->password, $user->matricule);
            return $user;
        }

        else if ($this->request->routeIs("import.teachers")) {
            if (in_array($row[2], User::pluck('email')->toArray())) {
                return null;
            }
            $teacherPermissions = \App\Models\Role::findByName(name : 'Enseignant')->permissions->pluck('name', 'id');
            $password = Helpers::generateRandomPassword();
            $user = new User([
                'email'     => $row[2],
                'lastname'  => $row[1],
                'firstname' => $row[0],
                'password'  => Hash::make($password),
            ]);
            $user->assignRole(roles : ['Enseignant']);
            foreach ($teacherPermissions as $permission) {
                $user->givePermissionTo($permission);
            }
            $user->update([
                'has_paid' => true, 'has_access' => true,
            ]);
            SendConnectionCredentialsToUserJob::dispatch($user->email, $user->password);
            return $user;
        }
    }
}
