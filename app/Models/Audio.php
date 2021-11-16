<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'audio_name',
        'audio_url',
        'mime',
    ];

    
    protected $hidden = [
        'pivot',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
