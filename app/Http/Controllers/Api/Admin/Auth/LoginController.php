<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin email not found',
                'data' => [],
            ]);
        }

        if (!Hash::check($request->password,  $admin->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Wrong password',
                'data' => [],
            ]);
        }

        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('admin')->attempt($credentials)) {
            $token = $admin->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'data' => [
                    'token' => $token,
                    'user' => $admin,
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid Credentials',
        ], 401);
    }
}
