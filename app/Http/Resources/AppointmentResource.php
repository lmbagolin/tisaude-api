<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Pacient;
use App\Models\Procedure;
use Illuminate\Http\Request;

class AppointmentResource extends AbstractResource
{
    public static $wrap = 'appointment';
    public static $model = Appointment::class;
    public static $attribsSearch = [
        'appointment.date',
        'doctor.id',
        'doctor.name',
        'pacient.id',
        'pacient.name'
    ];

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
            Doctor::class => 'doctors',
            Pacient::class => 'pacients',
            Procedure::class => 'procedures'
        ];
    }
}
