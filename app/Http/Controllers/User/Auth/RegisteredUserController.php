<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('user.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:' . User::class,
                'password' => 'required|max:255',
            ],
            [
                'name.required' => 'Name is required',
                'name.max' => 'Name is too long',

                'email.email' => 'Invalid email',
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists',

                'password.required' => 'Password is required',
                'password.max' => 'Password is too long',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', ['text' => $validator->errors()->first()])->withInput();
        }
    }
}
