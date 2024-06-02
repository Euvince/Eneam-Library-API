<?php

namespace App\Rules;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class ValueInValuesRequestRules implements ValidationRule
{

    public function __construct(
        private readonly array $values,
        private readonly string $message,
        private readonly Request $request,
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
        if (!in_array(
            mb_strtolower($this->request->type),
            array_map(
                fn (string $value) => mb_strtolower($value), $this->values
            )
        ))
        $fail($this->message);
    }
}
