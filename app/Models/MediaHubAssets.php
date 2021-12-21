<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaHubAssets extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "asset_type",
        "external_reference",
        "product_id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
