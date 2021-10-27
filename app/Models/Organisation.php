<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'organisation_name',
        'registration_number',
        'phone_number',
        'telephone_number',
        'organisation_role',
        'description',
        'website_link',
        'social_links',
        'organisation_type_id',
        'logo_id'
    ];

    protected $hidden = [
        'status',
        'date_activated',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function logo()
    {
        return $this->belongsTo(Image::class);
    }

    public function organisation_type()
    {
        return $this->belongsTo(OrganisationType::class);
    }
}
