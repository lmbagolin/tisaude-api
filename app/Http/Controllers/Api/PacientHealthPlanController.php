<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PacientHealthPlanCreateRequest;
use App\Http\Requests\PacientHealthPlanDeleteRequest;
use App\Http\Requests\PacientHealthPlanShowRequest;
use App\Http\Requests\PacientHealthPlanUpdateRequest;
use App\Http\Resources\PacientHealthPlanResource;
use App\Models\PacientHealthPlan;
use App\Repositories\PacientHealthPlanRepository;
use Exception;
use Illuminate\Http\Request;

class PacientHealthPlanController extends Controller
{
    protected $model = PacientHealthPlan::class;
    protected $resource = PacientHealthPlanResource::class;
    protected $repository = PacientHealthPlanRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Planos de Saúde dos Pacientes"},
     *     summary="Lista os Planos de Saúde dos Pacientes",
     *     description="Lista Planos de Saúde dos Pacientes",
     *     path="/api/pacients-health-plan",
     *     @OA\Response(response="200", description="Lista Planos de Saúde dos Pacientes"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PacientHealthPlanShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Planos de Saúde dos Pacientes"},
     *     summary="Cria um Planos de Saúde para o Paciente",
     *     description="Cria um Planos de Saúde para o Paciente",
     *     path="/api/pacients-health-plan",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Criado com sucesso"
     *      ),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PacientHealthPlanCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Planos de Saúde dos Pacientes"},
     *     summary="Lista o Plano de Saúde do Paciente",
     *     description="Lista o Plano de Saúde do Paciente",
     *     path="/api/pacients-health-plan/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Plano exibido"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PacientHealthPlanShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Planos de Saúde dos Pacientes"},
     *     summary="Atualiza o Plano de Saúde do Paciente",
     *     description="Atualiza o Plano de Saúde do Paciente",
     *     path="/api/pacients-health-plan/{id}",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Plano atualizado"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PacientHealthPlanUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Planos de Saúde dos Pacientes"},
     *     summary="Deleta o Plano de Saúde do Paciente",
     *     description="Deleta o Plano de Saúde do Paciente",
     *     path="/api/pacients-health-plan/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Plano deletado"),
     *     security={{"bearerAuth": {} }}
     * ),
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PacientHealthPlanDeleteRequest $request, $id)
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
