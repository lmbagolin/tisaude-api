<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PacientHealthPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pacient_health_plan';

    protected $fillable = [
        'pacient_id',
        'health_plan_id',
        'contract_id',
        'joined_at',
        'expire_at'
    ];

    protected $casts = [
        'pacient_id' => 'integer',
        'health_plan_id' => 'integer',
        'contract_id' => 'string',
        'joined_at' => 'date:Y-m-d',
        'expire_at' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'pacient_id' => 'required',
        'health_plan_id' => 'required',
    ];

    public function pacient()
    {
        return $this->hasOne(Pacient::class, 'id', 'pacient_id');
    }

    public function healthPlan()
    {
        return $this->hasOne(HealthPlan::class, 'id', 'health_plan_id');
    }
}
