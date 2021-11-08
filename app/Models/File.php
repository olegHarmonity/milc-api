<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'file_name',
        'file_url',
        'mime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
