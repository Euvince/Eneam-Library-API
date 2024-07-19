<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
{
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

        if ($routeName === "role.store" || $routeName === "role.update") {
            $rules = [
                'name' => ['required', 'string',
                    Rule::unique('roles')
                    ->ignore($this->route()->parameter('role'))
                    ->withoutTrashed()
                ],
                'permissions' => ['required', 'array', 'exists:permissions,id'],
            ];
        }
        else if ($routeName === 'destroy-roles') {
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

        if ($routeName === "role.store" || $routeName === "role.update") {
            if (request()->has('permissions') && count(request()->permissions) > 1) $messages['permissions.exists'] = "Une des permissions sélectionnées est invalide.";
        }
        else if ($routeName === "destroy-roles") {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs rôle(s)";
            $messages['ids.array'] = "L'ensemble de rôle(s) envoyé doit être un tableau";
        }

        return $messages;
    }

}
