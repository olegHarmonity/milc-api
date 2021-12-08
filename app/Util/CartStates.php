<?php
namespace App\Util;

class CartStates
{
    public static $NEW = 'new';
    public static $CONTRACT_ACCEPTED = 'contract_accepted';
    public static $CONTRACT_DENIED = 'contract_denied';
    public static $AWAITING_PAYMENT = 'awaiting_payment';
    public static $PAID = 'paid';
    public static $PAYMENT_FAILED= 'payment_failed';
    public static $ASSETS_SENT = 'assets_sent';
    public static $ASSETS_RECEIVED = 'assets_received';
    public static $COMPLETE = 'complete';
    public static $REJECTED = 'rejected';
    public static $CANCELLED = 'cancelled';
    public static $REFUNDED = 'refunded';
    
    public static function getStates(bool $implode = false)
    {
        $arr = [
            self::$NEW,
            self::$CONTRACT_ACCEPTED,
            self::$CONTRACT_DENIED,
            self::$AWAITING_PAYMENT,
            self::$PAID,
            self::$PAYMENT_FAILED,
            self::$ASSETS_SENT,
            self::$ASSETS_RECEIVED,
            self::$COMPLETE,
            self::$REJECTED,
            self::$CANCELLED,
            self::$REFUNDED,
        ];
        
        return $implode ? implode(',', $arr) : $arr;
    }
}

