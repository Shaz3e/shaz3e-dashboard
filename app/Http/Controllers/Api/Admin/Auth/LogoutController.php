<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        try {
            // Get Logged in user
            $admin = Auth::user();

            // delete all tokens, essentially logging the user out
            $admin->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to logout',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
