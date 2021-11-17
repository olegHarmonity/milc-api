<?php
namespace App\Util;

class ProductStatuses
{

    public static $ACTIVE = 'active';

    public static $INACTIVE = 'inactive';

    public static function getProductStatuses(bool $implode = false)
    {
        $arr = [
            self::$ACTIVE,
            self::$INACTIVE
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}

