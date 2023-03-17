<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'procedure';

    protected $fillable = ['name', 'price'];

    protected $casts = [
        'name' => 'string',
        'price' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'name' => 'required',
        'price' => 'nullable|numeric',
    ];
}
