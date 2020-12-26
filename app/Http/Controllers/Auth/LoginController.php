<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login() {
       $response = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);


        if(Auth::attempt($response))
        {
            return 'logeado';
        }

    }
}
