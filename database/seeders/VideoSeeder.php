<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VideoSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $videoName = 'video' . $i . '.mp4';
            $videoUrl = Storage::disk('public')->url('videos/' . $videoName);

            Video::factory()->create([
                'video_name' => $videoName,
                'video_url' => $videoUrl,
            ]);
        }
    }
}
