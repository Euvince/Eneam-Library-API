<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(
        private readonly Request $request
    )
    {
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input) : User
    {
        $routeUri = $this->request->route()->uri();
        switch ($routeUri) {
            case "api/register" :
                Validator::make($input, [
                    'firstname' => ['required', 'string', 'max:255'],
                    'lastname' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique(User::class),
                    ],
                    'password' => $this->passwordRules(),
                ])->validate();
                $user = User::create([
                    'firstname' => $input['firstname'],
                    'lastname' => $input['lastname'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                ])->assignRole(['Etudiant-Externe']);
                $externStudentPermissions = \App\Models\Role::findByName(name : 'Etudiant-Externe')->permissions->pluck('name', 'id');
                foreach ($externStudentPermissions as $permission) {
                    $user->givePermissionTo($permission);
                }
                return $user;
            break;

            case "api/register-teacher" :
                Validator::make($input, [
                    'firstname' => ['required', 'string', 'max:255'],
                    'lastname' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique(User::class),
                    ],
                    'password' => $this->passwordRules(),
                ])->validate();
                $user = User::create([
                    'firstname' => $input['firstname'],
                    'lastname' => $input['lastname'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                ])->assignRole(['Enseignant']);
                $teacherPermissions = \App\Models\Role::findByName(name : 'Enseignant')->permissions->pluck('name', 'id');
                foreach ($teacherPermissions as $permission) {
                    $user->givePermissionTo($permission);
                }
                return $user;
            break;
        }
    }
}
