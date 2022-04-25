<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Response;
use Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);
        if ($validation->fails()) {
            $response = [
                'status'=> 0,
                'message'=>"there is some missing fields",
                'data'=>$validation->errors(),
            ];
            return response()->json($response);
        }
        $request->merge(['password' => bcrypt($request->password)]);
        $user = User::create($request->all()); 
        if ($user) {
            $token = $user->createToken($user->email)->plainTextToken;
            $response = [
                'status'=>1,
                'message'=>"authenticated successfully",
                'data'=>$token,
            ];
            return response()->json($response);
        } 
        $response = [
            'status'=>1,
            'message'=>"unauthenticated"
        ];
        return response()->json($response);
    }
}
  