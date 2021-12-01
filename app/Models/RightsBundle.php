<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RightsBundle extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $hidden = [
        'pivot',
    ];
    
    public function price()
    {
        return $this->belongsTo(Money::class);
    }
    
    public function rights_information()
    {
        return $this->belongsToMany(RightsInformation::class, 'bundle_rights_information');
    }
}
