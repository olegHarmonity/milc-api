<?php
namespace App\Util;

class PaymentStatuses
{
    public static $UNPAID = 'unpaid';
    public static $SUCCESSFUL = 'successful';
    public static $FAILED = 'failed';
    public static $PENDING = 'pending';
    public static $CANCELLED = 'cancelled';
    
    public static $STRIPE_SUCCESS = 'succeeded';
    public static $STRIPE_PENDING = 'pending';
    public static $STRIPE_FAILED = 'failed';
}

