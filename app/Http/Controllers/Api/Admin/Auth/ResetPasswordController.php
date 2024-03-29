<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        $validated = $request->validated();

        // Check Token
        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->exists();

        if (!$tokenExists) {
            return response()->json([
                'status' => false,
                'message' => 'Password reset link is expired, please reset your password again.',
            ]);
        }

        // When Token and Email are valid
        // Reset Password
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin does not exists.',
            ]);
        }

        // Update Password
        $admin->password = bcrypt($request->password);
        $admin->save();

        // Delete Token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Send Response
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully. Please login',
        ]);
    }
}
