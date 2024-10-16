<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        // Send the verification email
        // $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($request->token_code === $user->verification_code) {
            $user->markEmailAsVerified();

            return response()->json(['message' => 'Email verified successfully.']);
        } else {
            return response()->json(['message' => 'Invalid token verification code.']);
        }
    }
}
