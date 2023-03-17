<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialtyCreateRequest;
use App\Http\Requests\SpecialtyDeleteRequest;
use App\Http\Requests\SpecialtyShowRequest;
use App\Http\Requests\SpecialtyUpdateRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use App\Repositories\SpecialtyRepository;
use Exception;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $model = Specialty::class;
    protected $resource = SpecialtyResource::class;
    protected $repository = SpecialtyRepository::class;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * @OA\Get(
     *     tags={"Especialidades"},
     *     summary="Lista as especialidades",
     *     description="Lista as especialidades",
     *     path="/api/specialties",
     *     @OA\Response(response="200", description="Lista as especialidades"),
     * ),
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SpecialtyShowRequest $request)
    {
        return ($this->resource)::collectionRequest($request);
    }

    /**
     * @OA\Post(
     *     tags={"Especialidades"},
     *     summary="Cria uma nova especialidades",
     *     description="Cria uma nova especialidades",
     *     path="/api/specialties",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(
     *          response="200",
     *          description="Cria uma nova especialidades"
     *      ),
     * ),
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialtyCreateRequest $request)
    {
        $object = ($this->repository)::save($request);
        return new $this->resource($object);;
    }

    /**
     * @OA\Get(
     *     tags={"Especialidades"},
     *     summary="Lista uma especialidade",
     *     description="Lista uma especialidade",
     *     path="/api/specialties/{id}",
     *     @OA\Response(response="200", description="Lista uma especialidade"),
     * ),
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialtyShowRequest $request, $id)
    {
        $object = ($this->model)::findOrFail($id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Put(
     *     tags={"Especialidades"},
     *     summary="Atualiza uma especialidades",
     *     description="Atualiza uma especialidades",
     *     path="/api/specialties/{id}",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome",
     *         required=true,
     *     ),     
     *     @OA\Response(response="200", description="Atualiza uma especialidades"),
     * ),
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialtyUpdateRequest $request, $id)
    {
        $object = ($this->repository)::save($request, $id);
        return new $this->resource($object);;
    }

    /**
     * @OA\Delete(
     *     tags={"Especialidades"},
     *     summary="Deleta uma especialidades",
     *     description="Deleta uma especialidades",
     *     path="%swagger.destroy.path%",
     *     @OA\Response(response="200", description="Deleta uma especialidades"),
     * ),
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialtyDeleteRequest $request, $id)
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
