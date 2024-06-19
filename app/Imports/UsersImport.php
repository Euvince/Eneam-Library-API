<?php

namespace App\Imports;

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
        /* dd($row); */
        /* return new User([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
        ]); */

        if ($this->request->routeIs("eneamiens.import")) {
            $eneamienStudentPermissions = \App\Models\Role::findByName(name : 'Etudiant-Eneamien')->permissions->pluck('name', 'id');
            $user = new User([
                'firstname' => $row[0],
                'lastname'  => $row[1],
                'email'     => $row[2],
                'matricule' => $row[3],
                'password'  => Hash::make($row[4]),
            ]);
            $user->assignRole(roles : ['Etudiant-Eneamien']);
            foreach ($eneamienStudentPermissions as $permission) {
                $user->givePermissionTo($permission);
            }
            return $user;
        }

        else if ($this->request->routeIs("teachers.import")) {
            $teacherPermissions = \App\Models\Role::findByName(name : 'Enseignant')->permissions->pluck('name', 'id');
            $user = new User([
                'firstname' => $row[0],
                'lastname'  => $row[1],
                'email'     => $row[2],
                'password'  => Hash::make($row[3]),
            ]);
            $user->assignRole(roles : ['Enseignant']);
            foreach ($teacherPermissions as $permission) {
                $user->givePermissionTo($permission);
            }
            $user->update([
                'has_paid' => true, 'has_access' => true,
            ]);

            return $user;
        }
    }
}
