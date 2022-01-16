<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->attachRole($request->role);
        $access_token = $user->createToken('token')->accessToken;
        return response()->json([
            'success' => true,
            'access_token' => $access_token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if(!auth()->attempt($request->validated())){
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json([
            'success' => true,
            'access_token' => $accessToken
        ], 200);
    }
}
