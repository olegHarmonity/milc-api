<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Traits\Messageable;

class Organisation extends Model
{
    use HasFactory, FormattedTimestamps, Messageable;

    protected $fillable = [
        'email',
        'organisation_name',
        'registration_number',
        'phone_number',
        'telephone_number',
        'organisation_role',
        'status',
        'description',
        'website_link',
        'social_links',
        'organisation_type_id',
        'logo_id',
        'country',
        'city',
        'address',
        'postal_code',
        'iban',
        'swift_bic',
        'bank_name',
    ];

    protected $hidden = [
        'date_activated',
    ];

    protected $casts = [
        'social_links' => 'array',
        'organisation_type_id' => 'integer',
    ];

    public function logo()
    {
        return $this->belongsTo(Image::class);
    }

    public function organisation_owner()
    {
        return $this->belongsTo(User::class);
    }

    public function organisation_type()
    {
        return $this->belongsTo(OrganisationType::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function vat_rules()
    {
        return $this->hasMany(VatRule::class);
    }

    public function hasUser(User $user)
    {
        foreach ($this->users() as $linkedUser) {
            if ($linkedUser->id === $user->id) {
                return true;
            }
        }
        return false;
    }
}
