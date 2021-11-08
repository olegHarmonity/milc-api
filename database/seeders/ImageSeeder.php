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

        for ($i = 1; $i <= 10; $i++) {
            $imageName = 'image' . $i . '.png';
            $imageUrl = Storage::disk('public')->url('images/'.$imageName);

            Image::factory()
                ->create([
                    'image_name' => $imageName,
                    'image_url' => $imageUrl,
                ]);
        }
    }
}
