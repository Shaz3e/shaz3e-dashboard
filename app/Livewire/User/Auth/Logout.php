<?php

namespace App\Livewire\User\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        $user = auth()->user();
        Auth::logout($user);
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.user.auth.logout');
    }
}
