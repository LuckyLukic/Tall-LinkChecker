<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Address;
use Livewire\Component;
use App\Models\UserDetail;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class Register extends Component
{
    public $name, $family_name, $company_name, $email, $password, $password_confirmation;
    public $phone_number, $birthday, $user_type = 'individual', $fiscal_code, $vat_number;
    public $street, $city, $province, $postal_code, $country;
    public $same_address = true, $billing_street, $billing_city, $billing_province, $billing_postal_code, $billing_country;

    protected $rules = [
        'name' => 'nullable|string|max:255|required_if:user_type,individual',
        'family_name' => 'nullable|string|max:255|required_if:user_type,individual',
        'company_name' => 'nullable|string|max:255|required_if:user_type,company',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'phone_number' => 'required|string|max:20',
        'birthday' => 'required|date',
        'user_type' => 'required' | 'in:individual,company',
        'fiscal_code' => 'nullable|string|max:16|required_if:user_type,individual',
        'vat_number' => 'nullable|string|max:11|required_if:user_type,company',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'country' => 'required|string|max:255',
        'billing_street' => 'nullable|string|max:255|required_if:same_address,false',
        'billing_city' => 'nullable|string|max:255|required_if:same_address,false',
        'billing_province' => 'nullable|string|max:255|required_if:same_address,false',
        'billing_postal_code' => 'nullable|string|max:10|required_if:same_address,false',
        'billing_country' => 'nullable|string|max:255|required_if:same_address,false',
    ];

    public function register()
    {
        $this->validate();

        $input = $this->all();

        app(\App\Actions\Fortify\CreateNewUser::class)->create($input);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
