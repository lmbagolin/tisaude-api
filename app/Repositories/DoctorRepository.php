<?php

namespace App\Repositories;

use App\Models\Doctor;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class DoctorRepository implements InterfaceRepository
{
    public static $model = Doctor::class;

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
            $attributes = $request->all();
            if ($id) {
                $object = self::update($id, $attributes);
            } else {
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
