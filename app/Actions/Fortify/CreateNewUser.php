<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Rules\ValueInValuesRequestRules;
use Illuminate\Support\Facades\Validator;
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
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required','string','email','max:255',
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
    }

    public function helper(array $input) : User {
        $routeUri = $this->request->route()->uri();
        switch ($routeUri) {
            case "register" :
                Validator::make($input, [
                    'firstname' => ['required', 'string', 'max:255'],
                    'lastname' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required','string','email','max:255',
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

            case "api/create-user" :
                Validator::make($input, [
                    'firstname' => ['required', 'string', 'max:255'],
                    'lastname' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required','string','email','max:255',
                        Rule::unique(User::class),
                    ],
                    'password' => $this->passwordRules(),
                    'phone_number' => ['nullable', 'phone:INTERNATIONAL'],
                    'birth_date' => ['nullable', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
                    'sex' => [
                        'nullable', 'before_or_equal:today',
                        new ValueInValuesRequestRules(
                            request : request(),
                            message : "Le sexe doit être soit 'Masculin', soit 'Féminin', soit 'Autre'.",
                            values : ['Masculin', 'Féminin', 'Autre']
                        )
                    ],
                    'roles' => ['required', 'array', 'exists:roles,id'],
                ])->validate();
                $user = User::create([
                    'firstname' => $input['firstname'],
                    'lastname' => $input['lastname'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'phone_number' => $input['phone_number'],
                    'birth_date' => $input['birth_date'],
                    'sex' => $input['sex'],
                ]);
                $user->roles()->sync($input['roles']);
                /**
                 * @var array $input
                 */
                foreach ($input['roles'] as $role) {
                    foreach (Role::find($role)->permissions as $permission) {
                        $user->givePermissionTo($permission->name);
                    }
                }
                return $user;
            break;
        }
    }
}
