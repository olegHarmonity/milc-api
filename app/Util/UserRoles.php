<?php

namespace App\Util;

class UserRoles
{
    public static $ROLE_USER = 'ROLE_USER';
    public static $ROLE_COMPANY_ADMIN = 'ROLE_COMPANY_ADMIN';
    public static $ROLE_ADMIN = 'ROLE_ADMIN';

    public static function getAllRoles(){
        return [
            self::$ROLE_USER,
            self::$ROLE_COMPANY_ADMIN,
            self::$ROLE_ADMIN
        ];
    }
}
