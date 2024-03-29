<?php

namespace App\Livewire\User\Auth;

use App\Mail\User\Auth\ForgotPassword as AuthForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Forgot Password')]
class ForgotPassword extends Component
{
    #[Validate]
    public $email = '';

    // Rules
    public function rules()
    {
        return [
            'email' => 'required|email|exists:' . User::class,
        ];
    }

    // Messages
    public function messages()
    {
        return [
            'email.exists' => 'We can\'t find a user with that e-mail address.',
        ];
    }

    public function forgotPassword()
    {
        // Validate
        $validated = $this->validate();

        // Get user data
        $user = User::where('email', $validated['email'])->first();

        // Generate random code with Str
        $token = Str::random(60);

        // Check email in db table name => 'password_reset_tokens'
        $password_reset_tokens = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        // Check for Token
        if(!$password_reset_tokens){
            // Insert Token in DB
            DB::table('password_reset_tokens')->insert([
                'email' => $validated['email'],
                'token' => $token,
            ]);
        }else{
            // Delete Token in DB
            DB::table('password_reset_tokens')
                ->where('email', $validated['email'])
                ->delete();

            // Insert Token in DB
            DB::table('password_reset_tokens')->insert([
                'email' => $validated['email'],
                'token' => $token,
            ]);
        }

        // Prepair mail data
        $mailData = [
            'name' => $user->name,
            'token' => $token,
            'url' => config('app.url') . '/reset/' . $this->email . '/' . $token,
        ];

        // Send Email to User
        Mail::to($user->email)->send(new AuthForgotPassword($mailData));

        // Reset Form
        $this->reset();

        // Flash message
        session()->flash('success', 'We have e-mailed you password reset link!');

    }

    public function render()
    {
        return view('livewire.user.auth.forgot-password');
    }
}
