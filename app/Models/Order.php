<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FormattedTimestamps;

class Order extends Model
{
    use HasFactory, FormattedTimestamps;
    
    
    protected $fillable = [
        'contact_email',
        'delivery_email',
        'organisation_name',
        'organisation_type',
        'organisation_email',
        'organisation_phone',
        'organisation_address',
        'organisation_registration_number',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_address',
        'rights_bundle_id',
        'state',
        'order_number'
    ];
    
    public function price()
    {
        return $this->belongsTo(Money::class, 'money');
    }
    
    public function vat()
    {
        return $this->belongsTo(Percentage::class, 'percentages');
    }
    
    public function total()
    {
        return $this->belongsTo(Money::class, 'money');
    }
    
    public function rights_bundle()
    {
        return $this->belongsTo(RightsBundle::class, 'rights_bundles');
    }
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisations');
    }
    
    public function buyer_user()
    {
        return $this->belongsTo(User::class, 'users');
    }
}
