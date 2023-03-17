<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HealthPlanCreateRequest;
use App\Http\Requests\HealthPlanDeleteRequest;
use App\Http\Requests\HealthPlanShowRequest;
use App\Http\Requests\HealthPlanUpdateRequest;
use App\Http\Resources\HealthPlanResource;
use App\Models\HealthPlan;
use App\Repositories\HealthPlanRepository;
use Exception;
use Illuminate\Http\Request;

class HealthPlanController extends Controller
{
    protected $model = HealthPlan::class;
    protected $resource = HealthPlanResource::class;
    protected $repository = HealthPlanRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Planos de Saúde"},
     *     summary="Lista de Planos de Saúde",
     *     description="Lista de Planos de Saúde",
     *     path="/api/health-plans",
     *     @OA\Response(response="200", description="Lista de Planos de Saúde"),
     * ),
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HealthPlanShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Planos de Saúde"},
     *     summary="Cria um novo Plano de Saúde",
     *     description="Cria um novo Plano de Saúde",
     *     path="/api/health-plans",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(
     *          response="200",
     *          description="Cria um novo Plano de Saúde"
     *      ),
     * ),
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HealthPlanCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Planos de Saúde"},
     *     summary="Exibe um Plano de Saúde",
     *     description="Exibe um Plano de Saúde",
     *     path="/api/health-plans/{id}",
     *     @OA\Response(response="200", description="Exibe um Plano de Saúde"),
     * ),
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HealthPlanShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Planos de Saúde"},
     *     summary="Atualiza um Plano de Saúde",
     *     description="Atualiza um Plano de Saúde",
     *     path="/api/health-plans/{id}",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(response="200", description="Atualiza um Plano de Saúde"),
     * ),
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HealthPlanUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Planos de Saúde"},
     *     summary="Deleta um Plano de Saúde",
     *     description="Deleta um Plano de Saúde",
     *     path="%swagger.destroy.path%",
     *     @OA\Response(response="200", description="Deleta um Plano de Saúde"),
     * ),
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthPlanDeleteRequest $request, $id)
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
