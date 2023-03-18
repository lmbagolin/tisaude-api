<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentShowRequest;
use App\Http\Requests\DoctorAddSpecialtyRequest;
use App\Http\Requests\DoctorCreateRequest;
use App\Http\Requests\DoctorDeleteRequest;
use App\Http\Requests\DoctorRemoveSpecialtyRequest;
use App\Http\Requests\DoctorShowRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Repositories\DoctorRepository;
use Exception;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected $model = Doctor::class;
    protected $resource = DoctorResource::class;
    protected $repository = DoctorRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Médicos"},
     *     summary="Lista de Médicos",
     *     description="Lista de Médicos",
     *     path="/api/doctors",
     *     @OA\Response(response="200", description="Lista de Médicos"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DoctorShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Médicos"},
     *     summary="Cria um novo Médico",
     *     description="Cria um novo Médico",
     *     path="/api/doctors",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Cria um novo Médico"
     *      ),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);
    }

    /**
     * @OA\Get(
     *     tags={"Médicos"},
     *     summary="Exibe um Médico",
     *     description="Exibe um Médico",
     *     path="/api/doctors/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Exibe um Médico"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Médicos"},
     *     summary="Atualiza um Médico",
     *     description="Atualiza um Médico",
     *     path="/api/doctors/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Atualiza um Médico"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Médicos"},
     *     summary="Deleta um Médico",
     *     description="Deleta um Médico",
     *     path="/api/doctors/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Deleta um Médico"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorDeleteRequest $request, $id)
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

    /**
     *     @OA\Post(
     *     tags={"Médicos"},
     *     summary="Adiciona uma ou várias especialidades a um Médico",
     *     description="Adiciona uma ou várias especialidades a um Médico",
     *     path="/api/doctors/{id}/add-specialties",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="specialty_ids[]",
     *         in="query",
     *         description="IDs das Especialidades",
     *         required=true,
     *         @OA\Schema(
     *             type="array",
     *             minItems=1,
     *             @OA\Items(type="integer")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Especialidades adicionadas"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addSpecialties(DoctorAddSpecialtyRequest $request, $id)
    {
        $object = ($this->repository)::addSpecialties($request, $id);
        return new $this->resource($object);
    }

    /**
     *     @OA\Post(
     *     tags={"Médicos"},
     *     summary="Remove uma especialidade de um Médico",
     *     description="Remove uma especialidade de um Médico",
     *     path="/api/doctors/{id}/remove-specialties",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="specialty_id",
     *         in="query",
     *         description="ID da Especialidade",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Especialidade removida"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeSpecialty(DoctorRemoveSpecialtyRequest $request, $id)
    {
        try {
            $object = ($this->model)::findOrFail($id);
            $object->specialties()->detach($request->input('specialty_id'));
            $object->refresh();
        } catch (Exception $e) {
            return response()->json([
                "message" => "Error removing record",
                'error' => $e->getMessage()
            ], 400);
        }

        return new $this->resource($object);
    }

    /**
     * @OA\Get(
     *     tags={"Médicos"},
     *     summary="Exibe as consultas de um Médico",
     *     description="Exibe as consultas de um Médico",
     *     path="/api/doctors/{id}/appointments",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Médico",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Consulta do Médico"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointments(Request $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return $object->appointments;
    }
}
