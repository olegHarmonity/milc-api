<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageName = 'image.png';
        $imageUrl = Storage::disk('public')->url('images/image.png');

        Image::factory()->create([
            'image_name' => $imageName,
            'image_url' => $imageUrl,
        ]);
    }
}
