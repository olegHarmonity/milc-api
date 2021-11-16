<?php

namespace App\Util;

class UserStatuses
{
    public static $ACTIVE = 'active';
    public static $INACTIVE = 'inactive';

    public static function getUserStatuses(bool $implode = false)
    {
        $arr = [
            self::$ACTIVE,
            self::$INACTIVE
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}
