<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersImport implements ToModel
{
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

        $user = new User([
            'firstname' => $row[0],
            'lastname'  => $row[1],
            'email'     => $row[2],
            'matricule' => $row[3],
            'password'  => Hash::make($row[4]),
        ]);

        return $user;
    }
}
