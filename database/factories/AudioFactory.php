<?php

namespace Database\Factories;

use App\Models\Audio;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class AudioFactory extends Factory
{
    protected $model = Audio::class;

    public function definition()
    {
        return [
            'audio_name' => 'audio.mp3',
            'audio_url' => Storage::disk('public')->url('audios/audio.mp3'),
            'mime' => 'mp3'
        ];
    }
}
