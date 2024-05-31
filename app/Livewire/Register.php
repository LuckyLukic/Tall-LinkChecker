<?php

namespace App\Livewire;


use Livewire\Component;

use App\Actions\Fortify\CreateNewUser;


class Register extends Component
{
    public $name, $family_name, $company_name, $email, $password, $password_confirmation;
    public $phone_number, $birthday, $user_type = 'individual', $fiscal_code, $vat_number;
    public $street, $city, $province, $postal_code, $country;
    public $same_address = true, $billing_street, $billing_city, $billing_province, $billing_postal_code, $billing_country;

    protected function rules()
    {
        return [
            'name' => $this->user_type === 'individual' ? 'required|string|max:255' : 'nullable|string|max:255',
            'family_name' => $this->user_type === 'individual' ? 'required|string|max:255' : 'nullable|string|max:255',
            'company_name' => $this->user_type === 'company' ? 'required|string|max:255' : 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'birthday' => 'required|date',
            'user_type' => 'required|in:individual,company',
            'fiscal_code' => $this->user_type === 'individual' ? 'required|string|max:16' : 'nullable|string|max:16',
            'vat_number' => $this->user_type === 'company' ? 'required|string|max:11' : 'nullable|string|max:11',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'billing_street' => $this->same_address ? 'nullable|string|max:255' : 'required|string|max:255',
            'billing_city' => $this->same_address ? 'nullable|string|max:255' : 'required|string|max:255',
            'billing_province' => $this->same_address ? 'nullable|string|max:255' : 'required|string|max:255',
            'billing_postal_code' => $this->same_address ? 'nullable|string|max:10' : 'required|string|max:10',
            'billing_country' => $this->same_address ? 'nullable|string|max:255' : 'required|string|max:255',
        ];
    }

    public function register()
    {
        $this->validate();

        $input = $this->all();

        app(CreateNewUser::class)->create($input);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
