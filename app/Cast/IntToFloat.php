<?php
namespace App\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class IntToFloat implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return ($value != 0) ? round($value/100,2) : 0.0;
    }
    
    public function set($model, $key, $value, $attributes)
    {
        return (int)(round($value*100,0));
    }
}

