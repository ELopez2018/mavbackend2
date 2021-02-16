<?php

namespace App\Http\Controllers;

use App\Mail\newRequest;
use App\Mail\response_request;
use App\Models\AssignedService;
use App\Models\PersonalData;
use App\Models\RequestService;
use App\Models\RequestType;
use App\Models\ServicesType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RequestsServicesController extends Controller
{
    /**
     * @api {post} http://miasesorvial3.test/api/v1/requestServices Registro
     * @apiName requestServices
     * @apiGroup Solicitudes
     *
     * @apiParam {String} name=required     Nombre del usuario que hace la solicitud.
     * @apiParam {String} email=required    Email del usuario que hace la solicitud.
     * @apiParam {number} request_type_id   Id del tipo de solicitud por ejemplo: Consulta, Capacitacion, diplomado.
     * @apiParam {number} service_type_id   Id del tipo de Servicio.
     * @apiParam {String} telefono=required Número de teléfono de contacto, es obligatorio mínimo 10 caracteres.
     * @apiParam {String} [mensaje]         Mensaje que envía el usuario a la plataforma.
     * @apiSuccessExample {json} Respuesta de radicado:
     *     {
     *       "message": "Solicitud radicada satisfactoriamente",
     *       "data": null,
     *       "code": 200,
     *       "details": null
     *     }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|between:10,45',
            'telefono' => 'required|min:10'
        ]);
        $datos = $request->all();
        if ($validator->fails()) {
            $response = [
                'message' => 'Error de validación: los parámetros no cumplen con las especificaciones',
                'data' => null,
                'code' => 400,
                'details' => $validator->errors(),
                'metadata' =>$datos,
            ];
        } else {
            $data = self::usuario($request); // devuelve el user_id y si es un usuario nuevo devuelve el user_id y el password tempporal
            $solicitudNueva = RequestService::create([
                'user_id' => $data['user_id'],
                'request_type_id' => $request->request_type_id,
                'service_type_id' => $request->service_type_id,
                'telefono' => $request->telefono,
                'mensaje' => $request->mensaje,
            ]);

            $solicitudNueva= self::SolicitudRecibida($solicitudNueva);
            $solicitudNueva->email = $datos['email'];
            $solicitudNueva->name  = $datos['name'];
            $solicitudNueva->pwd   = $data['passwordTemp'];


            $EmailaCliente = [
                "name"=>  $datos['name'],
                "email"=>  $datos['email'],
                "pwd"=>  $data['passwordTemp'],
                "solicitud"=>  $solicitudNueva['solicitud'],
                "servicio"=> $solicitudNueva['servicio'],
                "telefono"=> $request->telefono,
                "mensaje"=> $request->mensaje,
            ];

            $applicant= $datos['email'];
            $response = [
                'message' => 'Solicitud radicada satisfactoriamente',
                'data' => null,
                'code' => 200,
                'details' => $solicitudNueva
            ];

            $system= env('MAIL_SYSTEM','estarlin.elv@gmail.com');

            Mail::to($applicant)->queue(new response_request($EmailaCliente));

            Mail::to($system)->queue( new newRequest($EmailaCliente));

        }

        return  response()->json($response, $response['code']);
    }
    public  static function SolicitudRecibida($datos) {
        $solserv =  RequestService::find($datos->id);
        $solserv->solicitud = RequestType::find($solserv->request_type_id)->descripcion;
        $solserv->servicio = ServicesType::find($solserv->service_type_id)->descripcion;
        return $solserv;
    }

    public  static function usuario(Request $request)
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

    /**
     * @api {post} http://miasesorvial3.test/api/v1/requestServices Todas las Solicitudes
     * @apiName getAllrequestServices
     * @apiGroup Solicitudes
     *
     * @apiSuccessExample {json} Respuesta de La consulta:
     *   {
     *       "id": 1,
     *       "user_id": 3,
     *       "request_type_id": 1,
     *       "service_type_id": 1,
     *       "request_state_id": 1,
     *       "telefono": "3204454846",
     *       "mensaje": "La gente positiva cambia el mundo, mientras que la negativa lo mantiene como está",
     *       "finalizada": 0,
     *       "created_at": "2021-02-16 14:01:39",
     *       "updated_at": "2021-02-16 14:01:39",
     *       "deleted_at": null,
     *       "name": "Jorge Ramon Machado",
     *       "email": "programadorvillao@gmail.com",
     *       "state_descripcion": "RADICADA",
     *       "services_types_description": "ASESORÍA JURÍDICA ACCIDENTE DE TRÁNSITO",
     *       "request_types_description": "REPRESENTACIÓN JUDICIAL"
     *   }
     */
    public function index()
    {

        $solicitudes = DB::table('request_services AS rs')
            ->join('users AS u', 'u.id', '=', 'rs.user_id')
            ->join('request_states AS rst', 'rst.id', '=', 'rs.request_state_id')
            ->join('request_types AS rt', 'rt.id', '=', 'rs.request_type_id')
            ->join('services_types AS st', 'st.id', '=', 'rs.service_type_id')
            ->select('rs.*', 'u.name', 'u.email','rst.descripcion AS state_descripcion', 'st.descripcion AS services_types_description', 'rt.descripcion AS request_types_description')
            ->get();
        // $requestsServices = RequestService::all();
        // $newwArray = array();
        // foreach ($requestsServices as $valor) {
        //     $solicitud= self::SolicitudRecibida($valor);
        //     array_push($newwArray, $solicitud);
        // }
        // return $newwArray;

        return  $solicitudes;
    }

    public function show()
    {
        $requestsServices = RequestService::all();
        return  $requestsServices;
    }
    /**
     * @api {post} http://miasesorvial3.test/api/v1/requestServices Asignacion
     * @apiName serviceAssignment
     * @apiGroup Solicitudes
     *

     * @apiParam {Integer} assigned_to_id Tipo Integer es el id del Usuario role Asociado.
     * @apiParam {Integer} request_service_id Tipo Integer Numero de la Solicitud.
     * @apiParam {String} observaciones Tipo String observaciones de la solicitud.
     * @apiSuccessExample {json} Respuesta Exitosa:
     *   {
     *       "link": [],
     *       "data": null,
     *       "code": 200,
     *       "meta": {
     *           "code": 200,
     *           "message": "Solicitud asignada satisfactoriamente"
     *       }
     *   }
     */
    public function serviceAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assigned_to_id' => 'required|integer',
            'request_service_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $response = [
                'errors' =>  $validator->errors(),
                'data' => null,
                'meta' => [
                    'code' => 404,
                    'message' => 'Error en los datos enviados'
                ]
            ];
        } else {

            $requestService = RequestService::all();

            if (!$requestService->find($request->request_service_id)) {
                $response = [
                    'link' => [],
                    'data' => null,
                    'meta' => [
                        'code' => 404,
                        'message' => 'La solicitud de servicios no existe o llego a su final.'
                    ]
                ];
            } else {
                if (DB::table('users')->where('id', $request->assigned_to_id)->first()){
                    AssignedService::create([
                        'assigned_to_id' => $request->assigned_to_id,
                        'request_service_id' => $request->request_service_id,
                        'fechaAsignacion' => Carbon::now(),
                        'observaciones' => $request->observaciones,
                    ]);
                    $response = [
                        'link' => [],
                        'data' => null,
                        'meta' => [
                            'code' => 200,
                            'message' => 'Solicitud asignada satisfactoriamente.'
                        ]
                    ];
                } else {
                    $response = [
                        'link' => [],
                        'data' => null,
                        'meta' => [
                            'code' => 404,
                            'message' => 'El usuario no existe o está borrado.'
                        ]
                    ];
                }

            }
        }
        return  response()->json($response, $response['meta']['code']);
    }
}
