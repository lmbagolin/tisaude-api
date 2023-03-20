<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'appointment';

    protected $fillable = ['pacient_id', 'doctor_id', 'pacient_health_plan_id', 'date', 'is_private'];

    protected $with = ['pacient', 'doctor', 'pacientHealthPlan', 'procedures'];

    protected $casts = [
        'pacient_id' => 'integer',
        'doctor_id' => 'integer',
        'pacient_health_plan_id' => 'integer',
        'date' => 'date:Y-m-d H:i',
        'is_private' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'pacient_id' => 'required',
        'doctor_id' => 'required',
        'date' => ['required', 'date']
    ];

    public function pacient()
    {
        return $this->hasOne(Pacient::class, 'id', 'pacient_id');
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'id', 'doctor_id');
    }

    public function pacientHealthPlan()
    {
        return $this->hasOne(PacientHealthPlan::class, 'id', 'pacient_health_plan_id');
    }

    public function procedures()
    {
        return $this->belongsToMany(
            Procedure::class,
            'appointment_has_procedure',
            'appointment_id',
            'procedure_id'
        );
    }

    public function scopePacients(Builder $query): Builder
    {
        $query->join('pacient', 'pacient.id', '=', 'appointment.pacient_id');
        return $query;
    }

    public function scopeDoctors(Builder $query): Builder
    {
        $query->join('doctor', 'doctor.id', '=', 'appointment.doctor_id');
        return $query;
    }

    public function scopeProcedures(Builder $query): Builder
    {
        $query->leftJoin('appointment_has_procedure', 'appointment_has_procedure.appointment_id', '=', 'appointment.id');
        $query->leftJoin('procedure', 'appointment_has_procedure.procedure_id', '=', 'procedure.id');
        return $query;
    }
}
