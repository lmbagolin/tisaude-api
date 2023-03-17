<?php

namespace App\Http\Resources;

use App\Models\Doctor;

class DoctorResource extends AbstractResource
{
    public static $wrap = 'doctor';
    public static $model = Doctor::class;
    public static $attribsSearch = [];

    public static function model()
    {
        return self::$model;
    }

    public static function attribsSearch(): array
    {
        return self::$attribsSearch;
    }
}
