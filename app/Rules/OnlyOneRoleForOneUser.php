<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyOneRoleForOneUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count(request()->roles->toArray()) > 1)
            $fail("L'utilisateur ne peut avoir plusieurs rôles à la fois.");
    }
}
