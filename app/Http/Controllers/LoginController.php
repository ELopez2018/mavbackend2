<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @api {post} http://miasesorvial3.test/api/v1/login Login de Usuarios
     * @apiName login
     * @apiGroup Usuarios
     *
     * @apiParam {String} email Email del usuario es obligatorio.
     * @apiParam {String} password  Debe tener entre 6 y 20 caracteres.
     * @apiSuccessExample {json} Respuesta de logueo:
     *     HTTP/1.1 200 OK
     *       {
     *           "message": "Bienvendido al sistema",
     *           "data": {
     *               "user": {
     *                   "id": 1,
     *                   "role_id": 1,
     *                   "name": "Estarlin",
     *                   "email": "admin@admin.com",
     *                   "avatar": "/storage/users/default.png",
     *                   "email_verified_at": null,
     *                   "settings": [],
     *                   "created_at": "2020-12-28T20:17:52.000000Z",
     *                   "updated_at": "2020-12-28T20:17:52.000000Z"
     *                  },
     *               "token": "X2TVWp@]jj)zVzfbZ2&ht8k!&C9F@#d9mdj]Uw]F.k[vrP6MH7i7jSafN3?n"
     *           },
     *           "code": 200,
     *           "details": null
     *       }
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
