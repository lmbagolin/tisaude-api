<?php

namespace App\Http\Resources;

use App\Models\Procedure;

class ProcedureResource extends AbstractResource
{
    public static $wrap = 'procedure';
    public static $model = Procedure::class;
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
