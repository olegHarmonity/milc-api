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
        'organisation_id',
        'buyer_user_id',
        'state',
        'payment_status',
        'order_number',
        'transaction_id',
        'payment_method',
        'contract_accepted',
        'contract_accepted_at',
        'payment_started_at',
        'assets_sent_at',
        'assets_received_at',
        'completed_at',
        'rejected_at',
        'cancelled_at',
        'refunded_at',
        'paid_at'
    ];
    
    protected $casts = [
        'contract_accepted_at'=> 'datetime:Y-m-d H:i',
        'payment_started_at'=> 'datetime:Y-m-d H:i',
        'assets_sent_at'=> 'datetime:Y-m-d H:i',
        'assets_received_at'=> 'datetime:Y-m-d H:i',
        'completed_at'=> 'datetime:Y-m-d H:i',
        'rejected_at'=> 'datetime:Y-m-d H:i',
        'cancelled_at'=> 'datetime:Y-m-d H:i',
        'refunded_at'=> 'datetime:Y-m-d H:i',
        'paid_at'=> 'datetime:Y-m-d H:i'
    ];

    public function price()
    {
        return $this->belongsTo(Money::class);
    }

    public function vat_percentage()
    {
        return $this->belongsTo(Percentage::class);
    }

    public function vat()
    {
        return $this->belongsTo(Money::class);
    }

    public function total()
    {
        return $this->belongsTo(Money::class);
    }

    public function rights_bundle()
    {
        return $this->belongsTo(RightsBundle::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function buyer_user()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
