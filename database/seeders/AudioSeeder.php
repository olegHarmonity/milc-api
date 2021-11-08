<?php

namespace Database\Seeders;

use App\Models\Audio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AudioSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $audioName = 'audio' . $i . '.mp3';
            $audioUrl = Storage::disk('public')->url('audios/' . $audioName);

            Audio::factory()->create([
                'audio_name' => $audioName,
                'audio_url' => $audioUrl,
            ]);
        }
    }
}
