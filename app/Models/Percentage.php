<?php

namespace App\Models;

use App\Cast\IntToFloat;
use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $casts = [
        'value' => IntToFloat::class,
    ];
    
    protected $fillable = [
        'value',
    ];
}
