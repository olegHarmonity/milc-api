<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RightsInformation extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'available_from_date',
        'expiry_date',
        'available_rights',
        'holdbacks',
        'territories',
        'title',
        'short_description',
        'long_description', 
    ]; 

    protected $casts = [
        'available_from_date' => 'datetime:Y-m-d',
        'expiry_date' => 'datetime:Y-m-d',
        'territories' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function available_rights()
    {
        return $this->belongsToMany(MovieRight::class, 'rights_info_available_rights');
    }
}
