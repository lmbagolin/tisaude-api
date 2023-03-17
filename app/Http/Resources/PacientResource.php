<?php

namespace App\Http\Resources;

use App\Models\Pacient;

class PacientResource extends AbstractResource
{
    public static $wrap = 'pacient';
    public static $model = Pacient::class;
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
