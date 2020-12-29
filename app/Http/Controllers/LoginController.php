<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {

        // dd($request->all());
        if( $user= User::where('email', $request->email)->first())
        {

            if ( Hash::check($request->password, $user->password) )
            {
                $response = [
                    'user' => $user,
                    'token' => $user->api_token
                ];
                return response()->json($response);
            }

        }
        $response = [
        'message' => 'Email y/o Contraseña incorrectas',
        'token' => null
        ];

        return response()->json($response, 404);
    }
}
