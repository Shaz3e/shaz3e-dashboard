<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        $admin = auth()->guard('admin')->user();
        Auth::logout($admin);
        return redirect()->route('admin.logout');
    }

    public function render()
    {
        return view('livewire.admin.auth.logout');
    }
}
