<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductionInfoDirectors extends Pivot
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'production_info_id',
        'director_id',
    ];

    public function production_info()
    {
        return $this->belongsTo(ProductionInfo::class);
    }

    public function director()
    {
        return $this->belongsTo(Person::class);
    }
}
