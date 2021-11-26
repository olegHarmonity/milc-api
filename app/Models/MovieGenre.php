<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $hidden = [
        'pivot',
        'products'
    ];

    protected $fillable = [
        'name',
        'image_id',
    ];
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_genres');
    }
    
    public function getProductCountAttribute() {
        return count($this->products);
    }
    
    
}
