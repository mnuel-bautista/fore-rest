<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class AuthController extends Controller {

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first(); 

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([], 401); 
        }


        $token = JWT::create($user, env('JWT_SECRET_KEY', env('JWT_EXPIRE')));


        return response()->json(['user' => $user, 'token' => $token]);
    }
}
