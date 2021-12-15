<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaHubAssets extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'id',
    //     'file_name',
    //     'cid',
    //     'type',
    //     'dash_url',
    //     'hls_url',
    //     'dash_playlist',
    //     'hls_playlist',
    //     'thumbnail_url',
    //     'tenant_id',
    // ];

    protected $fillable = [
        "id",
        "title",
        "description",
        "external_reference",
        "genres",
        "poster",
        "poster_content_type",
        "poster_url",
        "organisation_id",
    ];

    protected $casts = [
        'genres' => 'array',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

}
