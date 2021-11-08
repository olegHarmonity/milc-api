<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FileSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $fileName = 'file' . $i . '.srt';
            $fileUrl = Storage::disk('public')->url('files/' . $fileName);

            File::factory()->create([
                'file_name' => $fileName,
                'file_url' => $fileUrl,
            ]);
        }
    }
}
