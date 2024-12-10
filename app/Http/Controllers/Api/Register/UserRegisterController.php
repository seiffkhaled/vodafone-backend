<?php

namespace App\Http\Controllers\Api\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'nullable|numeric|max:15',
            ]);
        $user = User::create($request->all());
        $token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}
