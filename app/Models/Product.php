<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'organisation_id',
        'production_info_id',
        'marketing_assets_id',
        'rights_information_id',
        'title',
        'alternative_title',
        'content_type',
        'runtime',
        'synopsis',
        'genre_id',
        'available_formats',
        'keywords',
        'languages',
        'links',
        'allow_requests',
        'production_info',
        'marketing_assets',
        'movie',
        'screener',
        'trailer',
        'dub_files',
        'subtitles',
        'promotional_videos',
    ];

    protected $casts = [
        'keywords' => 'array',
        'languages' => 'array',
        'links' => 'array',
    ];

    public function available_formats()
    {
        return $this->belongsToMany(MovieFormat::class, 'product_available_formats');
    }

    public function genre()
    {
        return $this->belongsTo(MovieGenre::class);
    }

    public function production_info()
    {
        return $this->belongsTo(ProductionInfo::class);
    }

    public function marketing_assets()
    {
        return $this->belongsTo(MarketingAssets::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function movie()
    {
        return $this->belongsTo(Video::class);
    }

    public function screener()
    {
        return $this->belongsTo(Video::class);
    }

    public function trailer()
    {
        return $this->belongsTo(Video::class);
    }

    public function dub_files()
    {
        return $this->belongsToMany(Audio::class, 'product_dub_files');
    }

    public function subtitles()
    {
        return $this->belongsToMany(File::class, 'product_subtitles');
    }

    public function promotional_videos()
    {
        return $this->belongsToMany(Video::class, 'product_promotional_videos');
    }

    public function rights_information()
    {
        return $this->belongsToMany(RightsInformation::class, 'product_rights_information');
    }
}
