<?php

namespace App\Rules;

use App\Models\SupportedMemory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class SupportedMemoryThemeRules implements ValidationRule
{

    public function __construct(
        private readonly Request $request
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        SupportedMemory::where([
            'first_author_matricule' => $this->request->first_author_matricule,
            'second_author_matricule' => $this->request->second_author_matricule,
            'first_author_firstname' => $this->request->first_author_firstname,
            'second_author_firstname' => $this->request->second_author_firstname,
            'first_author_firstname' => $this->request->first_author_firstname,
            'second_author_firstname' => $this->request->second_author_firstname,
        ]);
    }
}
