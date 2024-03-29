<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Mail\User\Auth\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgot(ForgotPasswordRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'User does not exists.',
            ]);
        }

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
            'url' => config('app.url') . '/reset/' . $request->email . '/' . $token,
        ];

        // Send Email to Admin who wants to change password
        Mail::to($user->email)->send(new ForgotPassword($mailData));

        return response()->json([
            'status' => true,
            'message' => 'Email sent successfully.',
        ]);
    }
}
