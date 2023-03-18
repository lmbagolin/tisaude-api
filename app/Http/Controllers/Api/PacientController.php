<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PacientCreateRequest;
use App\Http\Requests\PacientDeleteRequest;
use App\Http\Requests\PacientShowRequest;
use App\Http\Requests\PacientUpdateRequest;
use App\Http\Resources\PacientResource;
use App\Models\Pacient;
use App\Repositories\PacientRepository;
use Exception;
use Illuminate\Http\Request;

class PacientController extends Controller
{
    protected $model = Pacient::class;
    protected $resource = PacientResource::class;
    protected $repository = PacientRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Pacientes"},
     *     summary="Lista de Pacientes",
     *     description="Lista de Pacientes",
     *     path="/api/pacients",
     *     @OA\Response(response="200", description="Lista de Pacientes"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PacientShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Pacientes"},
     *     summary="Cria um novo Paciente",
     *     description="Cria um novo Paciente",
     *     path="/api/pacients",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Cria um novo Paciente"
     *      ),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PacientCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Pacientes"},
     *     summary="Exibe um Paciente",
     *     description="Exibe um Paciente",
     *     path="/api/pacients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Paciente",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Exibe um Paciente"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PacientShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Pacientes"},
     *     summary="Atualiza um Paciente",
     *     description="Atualiza um Paciente",
     *     path="/api/pacients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Paciente",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Atualiza um Paciente"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PacientUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Pacientes"},
     *     summary="Deleta um Paciente",
     *     description="Deleta um Paciente",
     *     path="/api/pacients/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do Paciente",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Deleta um Paciente"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PacientDeleteRequest $request, $id)
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
