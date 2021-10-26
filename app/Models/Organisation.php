<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

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
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
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
