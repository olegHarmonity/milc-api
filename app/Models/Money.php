<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Cast\IntToFloat;

class Money extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $casts = [
        'value' => IntToFloat::class,
    ];
    
    protected $fillable = [
        'value',
        'currency'
    ];
}
