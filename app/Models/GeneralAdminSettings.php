<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FormattedTimestamps;

class GeneralAdminSettings extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $fillable = [
        'iban',
        'swift_bic',
        'bank_name',
    ];
}
