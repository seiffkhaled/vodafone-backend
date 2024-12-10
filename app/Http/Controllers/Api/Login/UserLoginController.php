<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{
    /**
     * Handle user login and return an access token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        if ($user->is_logged_in) {
            return response()->json(['message' => 'user is already logged in'], 400);
        }
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        $token = $user->createToken('user-token')->plainTextToken;
        $user->is_logged_in = true;
        $user->save();
        return response()->json(['token' => $token]);
    }
    /**
     * Logout the user and revoke their tokens.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
        $user = User::where('email', $request->user()->email)->first();
        $user->is_logged_in = false;
        $user->save();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
