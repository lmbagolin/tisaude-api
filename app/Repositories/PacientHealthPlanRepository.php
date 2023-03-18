<?php

namespace App\Repositories;

use App\Models\PacientHealthPlan;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PacientHealthPlanRepository implements InterfaceRepository
{
    public static $model = PacientHealthPlan::class;

    public static function create(array $attributes)
    {
        $object = (self::$model)::create($attributes);
        return $object;
    }

    public static function update($id, array $attributes)
    {
        $object = (self::$model)::findOrFail($id);
        $object->update($attributes);
        return $object;
    }

    public static function save(Request $request, $id = null)
    {
        try {
            if ($id) {
                $attributes = $request->only(
                    "contract_id",
                    "joined_at",
                    "expire_at"
                );
                $object = self::update($id, $attributes);
            } else {
                $attributes = $request->all();
                $object = self::create($attributes);
            }
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'message' => $e->getMessage()
            ], 400));
        }
        return $object;
    }
}
