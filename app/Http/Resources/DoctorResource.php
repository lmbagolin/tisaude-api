<?php

namespace App\Http\Resources;

use App\Models\Doctor;
use App\Models\Specialty;

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

    public static function scopes()
    {
        return [
            Specialty::class => 'specialtys'
        ];
    }
}
