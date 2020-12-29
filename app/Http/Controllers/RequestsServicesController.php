<?php

namespace App\Http\Controllers;

use App\Models\PersonalData;
use App\Models\RequestServices;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RequestsServicesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|between:10,45',
            'telefono' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => 'Error de validación los parámetros no cumplen con las especificaciones',
                'data' => null,
                'code' => 404,
                'details' => $validator->errors()
            ];
        } else {
            $data = self::usuario($request); // devuelve el user_id y si es un usuario nuevo devuelve el user_id y el password tempporal
            RequestServices::create([
                'user_id' => $data['user_id'],
                'request_type_id' => $request->request_type_id,
                'service_type_id' => $request->service_type_id,
                'telefono' => $request->telefono,
                'mensaje' => $request->mensaje,
            ]);
            $response = [
                'message' => 'Solicitud radicada satisfactoriamente',
                'data' => null,
                'code' => 200,
                'details' => null
            ];

        }

        return  response()->json($response, $response['code']);
    }

    public function usuario(Request $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            $data = [
                'user_id' => $user->id,
                'passwordTemp' => null
            ];
        } else {
            $passwordTemp = Str::random(8);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'api_token' => Str::random(60),
                'role_id' => 2,
                'password' => Hash::make($passwordTemp),
            ]);
            PersonalData::create([
                'user_id' => $user->id,
                'telefonos' => $request->telefono,
                'pnombre' => $request->nombre,
            ]);
            $data = [
                'user_id' => $user->id,
                'passwordTemp' => $passwordTemp
            ];
        }
        return $data;
    }
}
