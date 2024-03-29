<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User email not found',
                'data' => [],
            ]);
        }

        if (!Hash::check($request->password,  $user->password)){
            return response()->json([
                'status' => false,
                'message' => 'Wrong password',
                'data' => [],
            ]);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
        ]);

    }
}
