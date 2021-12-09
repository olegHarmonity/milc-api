<?php
namespace App\Util;

class VatRuleNames
{

    public static $DOMESTIC = 'domestic';
    public static $INTERNATIONAL_OTHER = 'international_other';
    public static $BY_COUNTRY = 'by_country';

    public static function getRules(bool $implode = false)
    {
        $arr = [
            self::$DOMESTIC,
            self::$INTERNATIONAL_OTHER,
            self::$BY_COUNTRY,
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}

