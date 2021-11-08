<?php

namespace App\Util;

class ProductionStatuses
{
    public static $RELEASED = 'released';
    public static $UNRELEASED = 'unreleased';

    public static function getProductionStatuses()
    {
        return implode(',', [
            self::$UNRELEASED,
            self::$RELEASED
        ]);
    }
}
