<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FirstUpperCase implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $firstChar = mb_substr($value, 0, 1);
        if (mb_strtoupper($firstChar) !== $firstChar) {
            $fail('The first letter in the field :attribute must be uppercase.');
        }
    }
}
