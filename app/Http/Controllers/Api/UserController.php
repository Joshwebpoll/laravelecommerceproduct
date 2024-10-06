<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',

        ]);
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)

        ]);


        return response()->json([
            "message" => "successfully created",
            "status" => true
        ], 201);
    }

    public function login(Request $request)
    {


        $request->validate([

            'email' => 'required|email',
            'password' => 'required|string|min:8',

        ]);

        $user = User::where("email", $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $token = $user->createToken("mytoken")->plainTextToken;


                return response()->json([
                    "message" => "successfully loggin",
                    "status" => true,
                    "user" => $user,
                    'token' => $token

                ], 201);
            } else {
                return response()->json([
                    "message" => "Password does not match",
                    "status" => true
                ], 405);
            }
        } else {
            return response()->json([
                "message" => "Email does not match",
                "status" => false
            ], 405);
        }
        //  if(Hash::check($request->password,password)){

        //  }
    }

    public function profile()
    {

        $user = Auth::user();
        return response()->json([
            "user" =>  $user
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "message" => "user successfully logged out",
            "status" => true
        ]);
    }
}
