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
        'is_default',
        'accepted_at',
    ];
    
    protected $casts = [
        'accepted_at' => 'datetime:Y-m-d H:i',
    ];
    
    public function seller()
    {
        return $this->belongsTo(Organisation::class);
    }
    
    public function buyer()
    {
        return $this->belongsTo(Organisation::class);
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
