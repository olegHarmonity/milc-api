<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieContentType extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'name',
    ];
}
