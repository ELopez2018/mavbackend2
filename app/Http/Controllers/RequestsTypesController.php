<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use Illuminate\Http\Request;

class RequestsTypesController extends Controller
{
    /**
     * @api {post} http://miasesorvial3.test/api/v1/getServicesTypes Consulta Tipos de Servicios
     * @apiName getrequestTypes
     * @apiGroup Servicios
     *
     * @apiSuccessExample {json} Consulta exitosa:
     *   "links": [],
     *    "data": [
     *        {
     *            "id": 1,
     *            "descripcion": "Consulta",
     *            "activo": 1,
     *            "created_at": "2020-12-29T16:20:30.000000Z",
     *            "updated_at": "2020-12-29T16:20:30.000000Z"
     *        },
     *        {
     *            "id": 2,
     *            "descripcion": "Servicios de Centro de Conciliación",
     *            "activo": 1,
     *            "created_at": "2020-12-29T16:20:30.000000Z",
     *            "updated_at": "2020-12-29T16:20:30.000000Z"
     *        },
     *        {
     *            "id": 3,
     *            "descripcion": "Capacitación",
     *            "activo": 1,
     *            "created_at": "2020-12-29T16:20:30.000000Z",
     *            "updated_at": "2020-12-29T16:20:30.000000Z"
     *        },
     *        {
     *            "id": 4,
     *            "descripcion": "Diplomados en Actualización Jurídica",
     *            "activo": 1,
     *            "created_at": "2020-12-29T16:20:30.000000Z",
     *            "updated_at": "2020-12-29T16:20:30.000000Z"
     *        },
     *        {
     *            "id": 5,
     *            "descripcion": "Diplomados en Insolvencia",
     *            "activo": 1,
     *            "created_at": "2020-12-29T16:20:30.000000Z",
     *            "updated_at": "2020-12-29T16:20:30.000000Z"
     *        }
     *    ],
     *    "include": [],
     *    "meta": {
     *        "code": 200,
     *        "message": "Consulta realizada correctamente"
     *    }
     *}
     */
    public function index()
    {
        try {
            $services = RequestType::all();
            $response = [
                'links' => [],
                'data' => $services,
                'include' => [],
                'meta' => [
                    'code' => 200,
                    'message' => 'Consulta realizada correctamente'
                ]

            ];
        } catch (\Throwable $th) {
            $response = [
                'links' => [],
                'errors' =>  $th,
                'include' => [],
                'meta' => [
                    'code' => 200,
                    'message' => 'Consulta realizada correctamente'
                ]
            ];
        }


        return response()->json($response, $response['meta']['code']);
    }
}
