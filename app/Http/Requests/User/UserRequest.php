<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Rules\ValueInValuesRequestRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use App\Rules\UserCanNotBeEneamienAndExtern;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeName = request()->route()->getName();

        if ($routeName === "user.update") {
            $rules = [
                'firstname' => ['nullable', 'string', 'max:255'],
                'lastname' => ['nullable', 'string', 'max:255'],
                'email' => [
                    'required','string','email','max:255',
                    Rule::unique(User::class)
                    ->ignore(request()->route()->parameter(name : 'user'))
                    ->withoutTrashed(),
                ],
                /* 'password' => $this->passwordRules(), */
                'phone_number' => ['nullable', 'phone:INTERNATIONAL'],
                'birth_date' => ['nullable', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
                /* 'sex' => [
                    'nullable',
                    new ValueInValuesRequestRules(
                        request : request(),
                        message : "Le sexe doit être soit 'Masculin', soit 'Féminin', soit 'Autre'.",
                        values : ['Masculin', 'Féminin', 'Autre']
                    )
                ], */
                'sex' => ['nullable', 'in:Masculin,Féminin,Autre'],
                'roles' => ['sometimes', 'required', 'array', 'exists:roles,id'/* , new UserCanNotBeEneamienAndExtern() */],
            ];
        }

        else if ($routeName === 'destroy-users') {
            $rules = [
                'ids' => ['required', 'array'],
            ];
        }

        return $rules;
    }

    public function failedValidations (Validator $validator) : HttpResponseException {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'error' => true,
            'success' => false,
            'message' => 'Erreurs de validations des données',
            'errors' => $validator->errors()
        ]));
    }

    public function messages () : array {
        $messages = [];
        $routeName = request()->route()->getName();

        if ($routeName === "destroy-users") {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs utilisateur(s)";
            $messages['ids.array'] = "L'ensemble d'utilisateur(s) envoyé doit être un tableau";
        }

        return $messages;
    }

}
