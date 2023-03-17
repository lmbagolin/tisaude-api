<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcedureCreateRequest;
use App\Http\Requests\ProcedureDeleteRequest;
use App\Http\Requests\ProcedureShowRequest;
use App\Http\Requests\ProcedureUpdateRequest;
use App\Http\Resources\ProcedureResource;
use App\Models\Procedure;
use App\Repositories\ProcedureRepository;
use Exception;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    protected $model = Procedure::class;
    protected $resource = ProcedureResource::class;
    protected $repository = ProcedureRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Procedimentos"},
     *     summary="Lista de Procedimentos",
     *     description="Lista de Procedimentos",
     *     path="/api/procedures",
     *     @OA\Response(response="200", description="Lista de Procedimentos"),
     * ),
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProcedureShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Procedimentos"},
     *     summary="Cria um novo Procedimento",
     *     description="Cria um novo Procedimento",
     *     path="/api/procedures",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(
     *          response="200",
     *          description="Cria um novo Procedimento"
     *      ),
     * ),
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcedureCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Procedimentos"},
     *     summary="Exibe um procedimento",
     *     description="Exibe um procedimento",
     *     path="/api/procedures/{id}",
     *     @OA\Response(response="200", description="Exibe um procedimento"),
     * ),
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProcedureShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Procedimentos"},
     *     summary="Atualiza um procedimento",
     *     description="Atualiza um procedimento",
     *     path="/api/procedures/{id}",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(response="200", description="Atualiza um procedimento"),
     * ),
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcedureUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Procedimentos"},
     *     summary="Deleta um procedimento",
     *     description="Deleta um procedimento",
     *     path="%swagger.destroy.path%",
     *     @OA\Response(response="200", description="Deleta um procedimento"),
     * ),
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcedureDeleteRequest $request, $id)
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
