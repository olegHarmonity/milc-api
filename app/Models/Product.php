<?php

namespace App\Models;

use App\Traits\FormattedTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, FormattedTimestamps;

    protected $fillable = [
        'organisation_id',
        'production_info_id',
        'marketing_assets_id',
        'content_type_id',
        'title',
        'alternative_title',
        'runtime',
        'synopsis',
        'genres',
        'available_formats',
        'keywords',
        'original_language',
        'dubbing_languages',
        'subtitle_languages',
        'links',
        'allow_requests',
        'production_info',
        'marketing_assets',
        'movie_id',
        'screener_id',
        'trailer_id',
        'dub_files',
        'subtitles',
        'promotional_videos',
        'status'
    ];

    protected $casts = [
        'keywords' => 'array',
        'dubbing_languages' => 'array',
        'subtitle_languages' => 'array',
        'links' => 'array',
    ];
    
    protected $appends = ['is_saved'];
    
    public function getIsSavedAttribute()
    {
        $user = Auth::user();
        
        if(!$user){
            return false;
        }
        
        if($user->saved_products->contains($this->id)){
            return true;
        }
    }
    
    public function available_formats()
    {
        return $this->belongsToMany(MovieFormat::class, 'product_available_formats');
    }

    public function genres()
    {
        return $this->belongsToMany(MovieGenre::class, 'product_genres');
    }

    public function content_type()
    {
        return $this->belongsTo(MovieContentType::class );
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
