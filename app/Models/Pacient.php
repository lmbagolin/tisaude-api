<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pacient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pacient';

    protected $fillable = ['name', 'birthday', 'phones'];

    protected $with = ['pacientHealthPlan'];

    protected $casts = [
        'name' => 'string',
        'birthday' => 'string',
        'phones' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'name' => 'required',
        'birthday' => 'nullable|date',
        'phones' => 'nullable|array'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'pacient_id');
    }

    public function pacientHealthPlan()
    {
        return $this->hasMany(PacientHealthPlan::class, 'pacient_id')->with('healthPlan');
    }
}
