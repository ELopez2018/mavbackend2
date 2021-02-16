<?php

namespace App\Http\Controllers;

use App\Models\ServicesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesTypesController extends Controller
{
    /**
     * @api {post} http://miasesorvial3.test/api/v1/getServicesTypes Consulta
     * @apiName getServicesTypes
     * @apiGroup Servicios
     *
     * @apiSuccessExample {json} Consulta exitosa:
     *{
     *    "links": [],
     *    "data": [
     *        {
     *            "id": 1,
     *            "descripcion": "ASESORÍA JURÍDICA ACCIDENTE DE TRÁNSITO",
     *            "created_at": "2020-12-29T16:16:47.000000Z",
     *            "updated_at": "2020-12-29T16:16:47.000000Z",
     *            "activo": 1
     *        },
     *        {
     *            "id": 2,
     *            "descripcion": "ASESORÍA CORPORATIVA EN TRANSPORTE, TRÁNSITO Y SEGURIDAD VIAL",
     *            "created_at": "2020-12-29T16:16:47.000000Z",
     *            "updated_at": "2020-12-29T16:16:47.000000Z",
     *            "activo": 1
     *        },
     *        {
     *            "id": 3,
     *            "descripcion": "PROCESO LEGAL - CIVIL",
     *            "created_at": "2020-12-29T16:19:01.000000Z",
     *            "updated_at": "2020-12-29T16:19:01.000000Z",
     *            "activo": 1
     *        },
     *        {
     *            "id": 4,
     *            "descripcion": "PROCESO LEGAL - ADMINISTRATIVO",
     *            "created_at": "2020-12-29T16:19:01.000000Z",
     *            "updated_at": "2020-12-29T16:19:01.000000Z",
     *            "activo": 1
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
            // $services = ServicesType::all();
            $services = DB::table('services_types')
                            ->where('activo', '=', 1)
                            ->get();
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
                    'code' => 400,
                    'message' => 'Se presentaron errores'
                ]
            ];
        }


        return response()->json($response, $response['meta']['code']);
    }
}
