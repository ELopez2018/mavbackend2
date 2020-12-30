<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @api {post} http://miasesorvial3.test/api/v1/login Login de Usuarios
     * @apiName Login
     * @apiGroup Usuarios
     *
     * @apiParam {String} email Email del usuario es obligatorio.
     * @apiParam {String} password  Debe tener entre 6 y 20 caracteres.
     * @apiSuccessExample {json} Respuesta de registro:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Bienvendido al sistema",
     *       "data": null,
     *       "code": 200,
     *       "details": null
     *     }
     */
    public function login(Request $request)
    {

        $response = [
            'message' => 'Email y/o Contraseña incorrectas',
            'Data' => [],
            "code" => 404,
            "details" => null
        ];
        if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                $response = [
                    'message' => 'Bienvendido al sistema',
                    'data' => [
                        'user' => $user,
                        'token' => $user->api_token
                    ],
                    "code" => 200,
                    "details" => null
                ];
            }
        };

        return response()->json($response, $response['code']);
    }
}
