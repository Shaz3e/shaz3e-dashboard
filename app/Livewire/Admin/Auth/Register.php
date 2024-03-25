<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
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
            'email' => 'required|email|unique:' . Admin::class,
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function register()
    {
        $validated = $this->validate();

        $admin = Admin::create($validated);

        // Show success message
        session()->flash('success', 'Your account has been created. Please login');

        $this->reset();

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.admin.auth.register');
    }
}
