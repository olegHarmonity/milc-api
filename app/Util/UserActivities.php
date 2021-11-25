<?php
namespace App\Util;

class UserActivities
{
    public static $LOGIN = 'login';

    public static function getUserActivities(bool $implode = false)
    {
        $arr = [
            self::$LOGIN,
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}

