<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'video_name',
        'video_url',
        'mime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
