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
                'message'=>"register successfully",
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
    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            return response()->json([0, $validator->errors()->first(), $validator->errors()]);
        }
        $user = User::where('email', $request->email)->first();
        if(auth()->validate($request->all())) {
            $token = $user->createToken($request->email)->plainTextToken;
            return response()->json([1, 'login successfully', [
                'user' => $user,
                'token' => $token
            ]]);
        } 
        return response()->json(['0', 'unauthenticated']);
    }
}
  