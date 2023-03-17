<?php

namespace App\Http\Resources;

use App\Models\HealthPlan;

class HealthPlanResource extends AbstractResource
{
    public static $wrap = 'health_plan';
    public static $model = HealthPlan::class;
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
