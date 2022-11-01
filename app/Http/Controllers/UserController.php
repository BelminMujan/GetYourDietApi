<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserController extends Controller
{

    public function register(Request $request){
        $validated = $request->validate([
            "first_name" => "required|string|bail",
            "last_name" => "required|string|bail",
            "email" => "required|string|email|unique:users|bail",
            "password" => "required|confirmed|min:10|bail"
        ]);
        $user = User::create([
            "first_name" => $validated["first_name"],
            "last_name" => $validated["last_name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"])
        ]);
        $token = $user->createToken("authToken")->plainTextToken;
        return response()->json([
            "token" => $token,
            "user" => $user
        ], 200);
    }
    public function login(Request $request){
        $validated = $request->validate([
            "email" => "required|email|bail",
            "password" => "required|bail"
        ]);
        if(!Auth::attempt($validated)){
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }
        $user = User::where("email", $validated["email"])->firstOrFail();
        $token = $user->createToken("authToken")->plainTextToken;
        return response()->json([
            "message" => "Logged in succesfully",
            "user" => $user,
            "token" => $token
        ], 200);
    }

    public function authenticateUser(Request $request){
        $user = Auth::user();
        Log::Info($user);
    }
}
