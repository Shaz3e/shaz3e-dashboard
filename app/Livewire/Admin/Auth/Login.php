<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
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
            'email' => 'required|email|exists:' . Admin::class,
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

        // Login Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Show success message
            session()->flash('success', 'Welcome Back!');
            return redirect()->intended('admin.dashboard');
        } else {
            session()->flash('error', 'Invalid Credentials');
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
