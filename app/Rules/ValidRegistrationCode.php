<?php

namespace App\Rules;

use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRegistrationCode implements ValidationRule
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $registration_code = $this->userService->registrationCode;
        $attribute = str_replace('_', ' ', $attribute);

        if ($value !== $registration_code) {
            $fail("The $attribute is wrong.");
        }
    }
}
