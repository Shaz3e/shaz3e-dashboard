<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\RegisterRequest;
use App\Models\Admin;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $admin = Admin::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Your account has been created. Please login',
            'data' => $admin,
        ]);
    }
}
