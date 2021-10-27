<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationType extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'slug',
    ];
}
