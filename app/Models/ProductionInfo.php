<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionInfo extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $hidden = [
        'pivot',
    ];

    protected $fillable = [
        'release_year',
        'production_year',
        'production_status',
        'country_of_origin',
        'directors',
        'producers',
        'writers',
        'cast',
        'awards',
        'festivals',
        'box_office',
    ];

    protected $casts = [
        'release_year' => 'datetime:Y-m-d',
        'production_year' => 'datetime:Y-m-d',
        'awards' => 'array',
        'festivals' => 'array',
        'box_office' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function directors()
    {
        return $this->belongsToMany(Person::class, 'production_info_directors');
    }

    public function producers()
    {
        return $this->belongsToMany(Person::class, 'production_info_producers');
    }

    public function writers()
    {
        return $this->belongsToMany(Person::class, 'production_info_writers');
    }

    public function cast()
    {
        return $this->belongsToMany(Person::class, 'production_info_cast');
    }
}
