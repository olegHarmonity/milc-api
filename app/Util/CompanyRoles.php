<?php

namespace App\Util;

class CompanyRoles
{
    public static $BUYER = 'buyer';
    public static $SELLER = 'seller';
    public static $BOTH = 'both';

    public static function getRolesForValidation()
    {
        return implode(',', [
            self::$BUYER,
            self::$SELLER,
            self::$BOTH
        ]);
    }

    public static function getSellerRolesArray()
    {
        return [
            self::$SELLER,
            self::$BOTH
        ];
    }
}
