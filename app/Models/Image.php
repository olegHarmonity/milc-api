<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $hidden = [
        'pivot',
    ];
    
    protected $fillable = [
        'image_name',
        'image_url',
        'mime',
    ];
}
