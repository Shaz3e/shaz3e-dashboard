<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Register')]
class Register extends Component
{
    #[Validate]
    public $name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $password = '';

    #[Validate]
    public $confirm_password = '';

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:' . User::class,
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function register()
    {
        $validated = $this->validate();

        $user = User::create($validated);

        // Show success message
        session()->flash('success', 'Your account has been created. Please login');

        $this->reset();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.user.auth.register');
    }
}
