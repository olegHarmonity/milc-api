<?php
namespace App\Util;

class NotificationCategories
{
    
    public static $MESSAGE = 'message';
    
    public static $ORDER = 'order';
    
    public static $OTHER = 'other';
    
    public static function getCategories(bool $implode = false)
    {
        $arr = [
            self::$MESSAGE,
            self::$ORDER,
            self::$OTHER
        ];
        
        return $implode ? implode(',', $arr) : $arr;
    }
}

