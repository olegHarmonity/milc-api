<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingAssets extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'key_artwork',
        'production_images',
        'copyright_information',
        'links',
    ];

    protected $casts = [
        'links' => 'array',
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function key_artwork()
    {
        return $this->belongsTo(Image::class);
    }

    public function production_images()
    {
        return $this->belongsToMany(Image::class, 'marketing_assets_production_images');
    }
}
