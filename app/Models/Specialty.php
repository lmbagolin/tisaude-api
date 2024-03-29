<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'specialty';

    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    protected $casts = [
        'name' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $rules = [
        'name' => 'required'
    ];

    public function doctors()
    {
        return $this->belongsToMany(
            Doctor::class,
            'doctor_has_specialty',
            'speciality_id',
            'doctor_id',
        );
    }
}
