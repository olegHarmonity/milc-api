<?php
namespace App\Util;

class CartStates
{
    public static $NEW = 'new';
    
    public static function getStates(bool $implode = false)
    {
        $arr = [
            self::$NEW,
        ];
        
        return $implode ? implode(',', $arr) : $arr;
    }
}

