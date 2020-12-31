<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
 /**
 * @api {post} http://miasesorvial3.test/api/v1/users Registro
 * @apiName store
 * @apiGroup Usuarios
 *
 * @apiParam {String} name Nombre del usuario.
 * @apiParam {String} email Email del usuario es obligatorio.
 * @apiParam {String} password  Debe tener entre 6 y 20 caracteres.
 * @apiSuccessExample {json} Respuesta de registro:
 *     {
 *       "message": "Usuario creado correctamente",
 *       "data": null,
 *       "code": 200,
 *       "details": null
 *     }
 */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|between:10,45|unique:users',
            'password' => 'required|string|between:6,20'
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => 'Error de validación los parámetros no cumplen con las especificaciones',
                'data' => null,
                'code' => 404,
                'details' => $validator->errors()
            ];
        }
        else
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'api_token' => Str::random(60),
                'role_id' => 2,
                'password' => Hash::make($request->password),
            ]);
            $response = [
                'message' => 'Usuario creado correctamente',
                'data' => $user,
                'code' => 201,
                'details' => null
            ];
        }

        return  response()->json($response, $response['code']);
    }
}
