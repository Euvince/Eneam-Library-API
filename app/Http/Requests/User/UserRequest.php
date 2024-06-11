<?php

namespace App\Http\Requests\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Rules\ValueInValuesRequestRules;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
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
            'roles' => ['sometimes', 'required', 'array', 'exists:roles,id'],
        ];
    }
}
