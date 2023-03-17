<?php

namespace App\Http\Resources;

use App\Models\Appointment;

class AppointmentResource extends AbstractResource
{
    public static $wrap = 'appointment';
    public static $model = Appointment::class;
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
