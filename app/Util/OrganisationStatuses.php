<?php

namespace App\Util;

class OrganisationStatuses
{
    public static $PENDING = 'pending';
    public static $ACCEPTED = 'accepted';
    public static $DECLINED = 'declined';

    public static function getStatuses(bool $implode = false)
    {
        $arr = [
            self::$PENDING,
            self::$ACCEPTED,
            self::$DECLINED
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}
