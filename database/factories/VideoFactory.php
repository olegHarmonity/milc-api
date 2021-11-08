<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'video_name' => 'video.mp4',
            'video_url' => Storage::disk('public')->url('videos/video.mp4'),
            'mime' => 'mp4'
        ];
    }
}
