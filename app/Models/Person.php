<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    use HasFactory, FormattedTimestamps;

    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'image_id',
    ];
    
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
