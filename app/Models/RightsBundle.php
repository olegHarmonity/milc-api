<?php
namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RightsBundle extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'price_id',
        'product_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function price()
    {
        return $this->belongsTo(Money::class);
    }

    public function bundle_rights_information()
    {
        return $this->belongsToMany(RightsInformation::class, 'bundle_rights_information');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
