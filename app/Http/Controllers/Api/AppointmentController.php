<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentCreateRequest;
use App\Http\Requests\AppointmentDeleteRequest;
use App\Http\Requests\AppointmentShowRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use Exception;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $model = Appointment::class;
    protected $resource = AppointmentResource::class;
    protected $repository = AppointmentRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Consultas"},
     *     summary="Lista de Consultas",
     *     description="Lista de Consultas",
     *     path="/api/appointments",
     *     @OA\Response(response="200", description="Lista de Consultas"),
     * ),
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppointmentShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Consultas"},
     *     summary="Cria um nova Consulta",
     *     description="Cria um nova Consulta",
     *     path="/api/appointments",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(
     *          response="200",
     *          description="Cria um nova Consulta"
     *      ),
     * ),
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Consultas"},
     *     summary="Exibe uma Consulta",
     *     description="Exibe uma Consulta",
     *     path="/api/appointments/{id}",
     *     @OA\Response(response="200", description="Exibe uma Consulta"),
     * ),
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Consultas"},
     *     summary="Atualiza uma Consulta",
     *     description="Atualiza uma Consulta",
     *     path="/api/appointments/{id}",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(response="200", description="Atualiza uma Consulta"),
     * ),
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Consultas"},
     *     summary="Deleta uma Consulta",
     *     description="Deleta uma Consulta",
     *     path="%swagger.destroy.path%",
     *     @OA\Response(response="200", description="Deleta uma Consulta"),
     * ),
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentDeleteRequest $request, $id)
    {
        try {
            $object = ($this->model)::findOrFail($id);
            $object->delete();
        } catch (Exception $e) {
            return response()->json([
                "message" => "Error removing record",
                'error' => $e->getMessage()
            ], 400);
        }
        return response()->json(["message" => "Record removed successfully"]);
    }
}
