<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Address;
use App\Models\UserDetail;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['nullable', 'string', 'max:255', 'required_if:user_type,individual'],
            'family_name' => ['nullable', 'string', 'max:255', 'required_if:user_type,individual'],
            'company_name' => ['nullable', 'string', 'max:255', 'required_if:user_type,company'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'phone_number' => 'required|string|max:20',
            'birthday' => 'required|date',
            'user_type' => ['required', 'in:individual,company'],
            'fiscal_code' => ['nullable', 'string', 'max:16', 'required_if:user_type,individual'],
            'vat_number' => ['nullable', 'string', 'max:11', 'required_if:user_type,company'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'country' => ['required', 'string', 'max:255'],
            'same_address' => ['nullable', 'boolean'],
            'billing_street' => ['nullable', 'string', 'max:255', 'required_if:same_address,false'],
            'billing_city' => ['nullable', 'string', 'max:255', 'required_if:same_address,false'],
            'billing_province' => ['nullable', 'string', 'max:255', 'required_if:same_address,false'],
            'billing_postal_code' => ['nullable', 'string', 'max:10', 'required_if:same_address,false'],
            'billing_country' => ['nullable', 'string', 'max:255', 'required_if:same_address,false'],
        ])->validate();

        $address = Address::create([
            'street' => $input['street'],
            'city' => $input['city'],
            'province' => $input['province'],
            'postal_code' => $input['postal_code'],
            'country' => $input['country'],

        ]);

        $user = User::create([
            'name' => $input['user_type'] === 'individual' ? $input['name'] : null,
            'family_name' => $input['user_type'] === 'individual' ? $input['family_name'] : null,
            'company_name' => $input['user_type'] === 'company' ? $input['company_name'] : null,
            'email' => $input['email'],
            'password' => bCrypt($input['password']),
            'birthday' => $input['birthday'],
            'phone_number' => $input['phone_number'],
            'address_id' => $address->id,

        ]);

        $billingAddress = $address;
        if (empty($input['same_address'])) {
            $billingAddress = Address::create([
                'street' => $input['billing_street'],
                'city' => $input['billing_city'],
                'province' => $input['billing_province'],
                'postal_code' => $input['billing_postal_code'],
                'country' => $input['billing_country'],
            ]);
        }

        UserDetail::create([
            'user_id' => $user->id,
            'type' => $input['user_type'],
            'fiscal_code' => $input['fiscal_code'],
            'vat_number' => $input['vat_number'],
            'billing_address_id' => $billingAddress->id,
        ]);
        // Assegna il ruolo 'user' all'utente appena registrato
        $user->assignRole('user');

        return $user;
    }
}
