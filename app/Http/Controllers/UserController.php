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

    public function updateUser(Request $request){
        Log::Info($request);
        $user = Auth::user();
        if($request->has("first_name")){
            $v = $request->validate(["first_name" => "required|string|bail"]);
            $user->first_name = $v["first_name"];
        }
        if($request->has("last_name")){
            $v = $request->validate(["last_name" => "required|string|bail"]);
            $user->last_name = $v["last_name"];
        }
        if($request->has("email")){
            $v = $request->validate(["email" => "required|string|email|unique:users|bail"]);
            $user->email = $v["email"];
        }
        if($request->has("password")){
            $v = $request->validate(["password" => "required|confirmed|min:10|bail"]);
            $user->password = Hash::make($v["password"]);
        }
        $user->save();
        return response()->json([
            "message" => "Updated succesfully",
            "user" => $user,
        ], 200);
    }
}
