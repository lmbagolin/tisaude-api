<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface InterfaceRepository
{
    public static function save(Request $attributes);
    public static function create(array $attributes);
    public static function update($id, array $attributes);
}
