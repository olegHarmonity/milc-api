<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieRight extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'name',
    ];
}
