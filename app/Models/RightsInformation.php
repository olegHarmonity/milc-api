<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RightsInformation extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'available_from_date',
        'expiry_date',
        'available_rights',
        'holdbacks',
        'territories',
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
        return $this->belongsToMany(MovieRight::class, 'rights_information_available_rights');
    }
}
