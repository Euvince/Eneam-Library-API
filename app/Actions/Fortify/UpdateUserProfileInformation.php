<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\ValueInValuesRequestRules;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AskAgainEmailVerificationLinkJob;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation extends Controller implements UpdatesUserProfileInformation
{

    public function __construct(
        private readonly Request $request
    )
    {
    }

    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        /* $this->authorize('UpdateProfileInformations', $user); */
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required','string','email','max:255',
                Rule::unique('users')->ignore(id : $user->id),
            ],
            'phone_number' => ['nullable', 'phone:INTERNATIONAL'],
            'birth_date' => ['nullable', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            /* 'sex' => [
                'nullable', 'before_or_equal:today',
                new ValueInValuesRequestRules(
                    request : request(),
                    message : "Le sexe doit être soit 'Masculin', soit 'Féminin', soit 'Autre'.",
                    values : ['Masculin', 'Féminin', 'Autre']
                )
            ], */
            'sex' => ['nullable', 'in:Masculin,Féminin,Autre']
        ])->validateWithBag('updateProfileInformation');

        $sex = $this->request->has('sex')
            ? $input['sex']
            : NULL;
        $birthDate = $this->request->has('birth_date')
            ? $input['birth_date']
            : NULL;
        $phoneNumber = $this->request->has('phone_number')
            ? $input['phone_number']
            : NULL;

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        }
        else {
            $user->forceFill([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'email' => $input['email'],
                'phone_number' => $phoneNumber,
                'birth_date' => $birthDate,
                'sex' => $sex,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $sex = $this->request->has('sex')
            ? $input['sex']
            : NULL;
        $birthDate = $this->request->has('birth_date')
            ? $input['birth_date']
            : NULL;
        $phoneNumber = $this->request->has('phone_number')
            ? $input['phone_number']
            : NULL;

        $user->forceFill([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'phone_number' => $phoneNumber,
            'birth_date' => $birthDate,
            'sex' => $sex,
        ])->save();

        AskAgainEmailVerificationLinkJob::dispatch($user);
    }
}
