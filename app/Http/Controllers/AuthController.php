<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;


class AuthController extends Controller{

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['register', 'login']]); # no need bearer token to access
    }

      public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'string', 'max:255', 'unique:users'],
            //'email_address' => ['required', 'string', 'max:255|email', 'unique:users'],
            // 'password' => 'required|between:6,255|confirmed', #password_confirmation
            'password' => 'required|between:6,255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
            
        } else {
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email_address = $request->email_address;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->save();

            return $this->login($request);
        }
    }


    public function login(Request $request){
        $credentials = $request->only('email_address', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return Response()->json($token);
        }
 
        return response()->json(['error' => 'Email or Password incorrect'], 401);
    }

    public function logout(){
        if (Auth::user()){
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out!'], 200);
        }

        return response()->json(['error' => 'User was not logged in!'], 401);
        
    }


    public function me(){
        //return response()->json(auth()->user());
        return response()->json($this->guard()->user());
    }



    /**
     * Refresh a token
     */
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }


    public function guard(){
        return Auth::guard();
    }

     /**
     * Get the token array structure.
     */
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}