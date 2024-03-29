<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Login')]
class Login extends Component
{
    #[Validate]
    public $email = '';

    #[Validate]
    public $password = '';

    // Validation Rules
    public function rules()
    {
        return [
            'email' => 'required|email|exists:' . User::class,
            'password' => 'required',
        ];
    }

    // Validation Messages
    public function messages()
    {
        return [
            'email.exists' => 'This email is not registered with us.',
        ];
    }

    public function login()
    {
        // Validated Request
        $validated = $this->validate();

        // Check Credentials
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        // Login User
        if (Auth::attempt($credentials)) {
            // Show success message
            session()->flash('success', 'Welcome Back!');
            return redirect()->intended('dashboard');
        } else {
            session()->flash('error', 'Invalid Credentials');
        }
    }

    public function render()
    {
        return view('livewire.user.auth.login');
    }
}
