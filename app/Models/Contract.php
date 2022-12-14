<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FormattedTimestamps;

class Contract extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $fillable = [
        'contract_text',
        'contract_text_part_2',
        'contract_appendix',
        'is_default',
        'accepted_at',
    ];
    
    protected $casts = [
        'accepted_at' => 'datetime:Y-m-d H:i',
    ];
    
    public function seller()
    {
        return $this->belongsTo(Organisation::class, 'seller_id',);
    }
    
    public function buyer()
    {
        return $this->belongsTo(Organisation::class, 'buyer_id');
    }
    
    public function rights_bundle()
    {
        return $this->belongsTo(RightsBundle::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
