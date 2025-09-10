<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Events\UserRegister;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{
            $request->validated();
            $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password), 
                    ]);
            $token = JWTAuth::fromUser($user);
            event(new UserRegister($user));
            return response()->json([
                'message' => 'Registred Successfully!',
                'token' => $token,
            ]);
        }catch(\Exception $e){
            return response()->json(['Error' => "$e"]);
        }

    }

    public function login(LoginRequest $request)
    {
        try{
            $request->validated();
            $user = User::where('email', $request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return response()->json(['Error' => 'Invalid Email or Password']);
            }
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'token' => $token,
            ]);
        }catch(\Exception $e){
            return response()->json(['Error' => "$e"]);
        }
    }

    public function logout(Request $request)
    {
        try{
            $user = $request->user();
            JWTAuth::invalidate(JWTAuth::getToken($user));
            return response()->json(['message' => 'Logout Successfully!']);
        }catch(\Exception $e){
            return response()->json(['Error' => "$e"]);
        }
    }
}
