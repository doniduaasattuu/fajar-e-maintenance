<?php

namespace App\Rules;

use App\Models\User;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_null($value) && !empty($value)) {
            if (User::find($value)) {
                $fail("The user $value is already registered.");
            }
        }
    }
}
