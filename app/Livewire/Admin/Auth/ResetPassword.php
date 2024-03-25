<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Reset Password')]
class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $confirm_password;

    // Mount to check if token and email match
    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    // Reset password
    public function resetPassword()
    {
        // Check Token
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->exists();

        // When Token is not valid or expired
        if (!$tokenExists) {
            session()->flash('error', 'Password reset link is expired, please reset your password again.');
            return redirect()->route('admin.forgot.password');
        }

        // When Token and Email are valid
        // Reset Password
        $admin = Admin::where('email', $this->email)->first();

        // Check if admin exists
        if ($admin) {

            // Validate input
            $validator = Validator::make(
                [
                    'password' => $this->password,
                    'confirm_password' => $this->confirm_password
                ],
                [
                    'password' => 'required|min:8|max:255',
                    'confirm_password' => 'required|same:password'
                ],
                [
                    'password.required' => 'Password is required',
                    'confirm_password.required' => 'Confirm password is required',
                    'confirm_password.same' => 'Passwords do not match',
                    'password.min' => 'Password must be at least 8 characters',
                    'password.max' => 'Password must not exceed 255 characters',
                ],
            );

            // Check if validation fails
            if ($validator->fails()) {

                // Flash error message with validation errors
                session()->flash('error', $validator->errors()->first());

                return redirect()->back();
            }

            // Update Password
            $admin->password = Hash::make($this->password);
            $admin->save();

            // Delete Token
            DB::table('password_reset_tokens')
                ->where('email', $this->email)
                ->delete();

            // Success message
            session()->flash('success', 'Password reset successfully. Please login with your new password.');

            return redirect()->route('admin.login');
        } else {
            // Error message
            session()->flash('error', 'This Admin is not exists');
            return redirect()->route('admin.register'); // Add this line to return the redirect response
        }
    }


    public function render()
    {
        return view('livewire.admin.auth.reset-password');
    }
}
