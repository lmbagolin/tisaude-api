<?php

namespace App\Http\Resources;

use App\Models\Specialty;

class SpecialtyResource extends AbstractResource
{
    public static $wrap = 'specialty';
    public static $model = Specialty::class;
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
