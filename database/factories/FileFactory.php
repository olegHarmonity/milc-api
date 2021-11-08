<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition()
    {
        return [
            'file_name' => 'file.srt',
            'file_url' => Storage::disk('public')->url('files/file.srt'),
            'mime' => 'srt'
        ];
    }
}
