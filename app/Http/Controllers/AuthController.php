<?php

namespace App\Http\Controllers;

use App\Models\User;
use PharIo\Manifest\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(($data['password'])),
        ]);
        $user->assignRole('user');
        return response()->json([
            'status' => 200,
            'message' => 'User Registered Successfully',
            'data' => $user,
        ]);
    }
    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email',$request->email)->first();
        $isAuth = Hash::check($request->password, $user->password);
        
        if(!$user || !$isAuth){
            return response()->json([
                'status' => 200,
                'message' => 'Creadentials Not Found ',
                'data' => "",
            ]);
        }
        $token = $user->createToken('admin-token', ['create', 'update', 'delete'])->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => 'User Logged In Successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
        

    }
    public function logout(){
        $user  = Auth::user();
        if($user->currentAccessToken()->delete()){
            return response()->json([
                'status' => 200,
                'message' => 'User Logged Out Successfully',
            ]);
        }
    }
}
