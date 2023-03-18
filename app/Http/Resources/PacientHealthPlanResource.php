<?php

namespace App\Http\Resources;

use App\Models\PacientHealthPlan;

class PacientHealthPlanResource extends AbstractResource
{
    public static $wrap = 'pacient_health_plan';
    public static $model = PacientHealthPlan::class;
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
