<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules()
    {
        return [
            'required',
            'string',
            Password::min(8) // Minimum length
                ->mixedCase() // Must include both upper and lower case letters
                ->letters() // Must include at least one letter
                ->numbers() // Must include at least one number
                ->symbols(), // Must include at least one symbol
            'confirmed',
        ];
    }
}
