<?php

namespace App\Http\Resources;

use App\Models\User;

class UserResource extends AbstractResource
{
    public static $wrap = 'user';
    public static $model = User::class;
    public static $attribsSearch = ['name', 'email'];

    public $isLogin = false;

    public static function model()
    {
        return self::$model;
    }

    public static function attribsSearch(): array
    {
        return self::$attribsSearch;
    }
}
