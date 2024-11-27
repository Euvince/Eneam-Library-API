<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\SamePasswordEnteredByUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        /* $this->authorize('UpdatePassword', $user); */
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
            // new SamePasswordEnteredByUser()
        ], [
            'current_password.current_password' => __('Le mot de passe courant saisi ne correspond pas à votre mot de passe actuel.'),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
