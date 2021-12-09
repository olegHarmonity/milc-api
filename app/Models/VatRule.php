<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FormattedTimestamps;

class VatRule extends Model
{
    use HasFactory, FormattedTimestamps;
    
    protected $fillable = [
        'vat_id',
        'organisation_id',
        'rule_type',
        'country',
    ];
    
    public function vat()
    {
        return $this->belongsTo(Percentage::class);
    }
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
