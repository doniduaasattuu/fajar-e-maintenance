<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SameAsUnique implements ValidationRule
{

    public function __construct(private ?string $unique_id)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value !== null) {
            $id = preg_replace('/[^0-9]/i', '', $value);

            if ($id !== $this->unique_id) {
                $fail('The ' . str_replace('_', ' ', $attribute) . ' id must be same as unique id.');
            }
        }
    }
}
