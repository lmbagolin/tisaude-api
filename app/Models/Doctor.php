<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'doctor';

    protected $fillable = ['name', 'crm'];
    protected $with = ['specialties'];
    protected $hidden = ['pivot'];

    protected $casts = [
        'name' => 'string',
        'crm' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'name' => 'required'
    ];

    public function specialties()
    {
        return $this->belongsToMany(
            Specialty::class,
            'doctor_has_specialty',
            'doctor_id',
            'speciality_id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(
            Appointment::class,
            'doctor_id',
            'id'
        );
    }

    public function scopeSpecialtys(Builder $query): Builder
    {
        $query->leftJoin('doctor_has_specialty', 'doctor_has_specialty.doctor_id', '=', 'doctor.id');
        $query->leftJoin('specialty', 'doctor_has_specialty.speciality_id', '=', 'specialty.id');
        return $query;
    }
}
