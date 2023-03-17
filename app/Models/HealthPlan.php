<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'health_plan';

    protected $fillable = ['description', 'phone'];

    protected $casts = [
        'description' => 'string', 
        'phone' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'description' => 'required'
    ];
}
