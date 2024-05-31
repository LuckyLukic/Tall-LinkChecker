<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email, $password, $remember_me = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
