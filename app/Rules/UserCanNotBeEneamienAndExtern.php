<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserCanNotBeEneamienAndExtern implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $role1Id = \App\Models\Role::findByName('Etudiant-Externe')->first()->id;
        $role2Id = \App\Models\Role::findByName('Etudiant-Eneamien')->first()->id;
        if (array_intersect([$role1Id, $role2Id], request()->roles->toArray()))
            $fail("L'utilisateur ne peut être Énéamien et Externe à la fois.");
    }
}
