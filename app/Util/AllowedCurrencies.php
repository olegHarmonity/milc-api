<?php
namespace App\Util;

class AllowedCurrencies
{

    public static $EUR = 'EUR';

    public static $USD = 'USD';

    public static $GBP = 'GBP';

    public static function getCurrencies(bool $implode = false)
    {
        $arr = [
            self::$EUR,
            self::$USD,
            self::$GBP
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}

