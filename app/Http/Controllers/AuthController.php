<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Responses\Response;
class AuthController extends Controller
{

    public function register(RegistrationRequest $request)
    {
        $data = $request->input();

        if ($data['type'] == 1) {
            $user = Expert::create([
                "full_name" => $request->full_name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "type" => $data['type']
            ]);

            $token = Auth::guard('experts')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);
        }

        if ($data['type'] == 2) {
            $user = User::create([
                "full_name" => $request->full_name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                'type' => $data['type']
            ]);

            $token = Auth::guard('users')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);
        }

        if ($user) {
            return Response::registerSuccess("Registration successfully", $user, $token,200);
        } else {
            return Response::Failure("Registration failed..!",401);
        }

    }

    //////////////////////////////////////////////////////////////////////////
    public function login(LoginRequest $request)
    {
        $token = null;

        $user = User::where('email', $request->email)->first();
        $expert = Expert::where('email', $request->email)->first();

        if ($expert) {

            $token = Auth::guard('experts')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);

            if($token){
                return Response::loginSuccess("Expert login successfully",$user,"user",$expert->id,$token,200);
            }
            else{
                return Response::Failure("Password does not match.",422);
            }

        } else if ($user) {
            $token = Auth::guard('users')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);

            if($token){
                return Response::loginSuccess("User login successfully",$user,"user",$user->id,$token,200);
 }
            else{
                return Response::Failure("Password does not match.",422);
            }
        }
        else {
            return Response::Failure("The email dose not match ",401);
        }
    }

    //////////////////////////////////////////////////////////////////////////
    function logout(Request $request)
    {
        // check if request has token
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            // invalidate token
            JWTAuth::invalidate(JWTAuth::getToken());
            return Response::logoutSuccess("Logout successfully",200);

        } catch (JWTException $e) {
            return Response::Failure("Failed to logout..!",500);

        }
    }
}
