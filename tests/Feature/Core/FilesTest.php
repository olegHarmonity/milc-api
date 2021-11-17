<?php

namespace Tests\Feature\Core;

use Illuminate\Http\UploadedFile;
use Tests\ApiTestCase;

class FilesTest extends ApiTestCase
{
    
    public function test_post_image_company_admin()
    {
        $this->loginCompanyAdmin();
        $data = [
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true),
        ];
        
        $response = $this->post('/api/images', $data);
        $response->assertStatus(201);
    }
    
    public function test_post_image()
    {
        $this->loginAdmin();
        $data = [
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true),
        ];

        $response = $this->post('/api/images', $data);
        $response->assertStatus(201);
    }

    public function test_post_audio()
    {
        $this->loginAdmin();
        $data = [
            'audio' => new UploadedFile(resource_path('test-files/audio.mp3'), 'audio.mp3', null, null, true),
        ];

        $response = $this->post('/api/audios', $data);
        $response->assertStatus(201);
    }

    public function test_post_video()
    {
        $this->loginAdmin();
        $data = [
            'video' => new UploadedFile(resource_path('test-files/video.mp4'), 'video.mp4', null, null, true),
        ];

        $response = $this->post('/api/videos', $data);
        $response->assertStatus(201);
    }

    public function test_post_file()
    {
        $this->loginAdmin();
        $data = [
            'file' => new UploadedFile(resource_path('test-files/file.srt'), 'file.srt', null, null, true),
        ];

        $response = $this->post('/api/files', $data);
        $response->assertStatus(201);
    }

    public function test_delete_image()
    {
        $this->loginAdmin();

        $response = $this->delete('/api/images/11');
        $response->assertStatus(204);
    }

    public function test_delete_video()
    {
        $this->loginAdmin();

        $response = $this->delete('/api/videos/11');
        $response->assertStatus(204);
    }

    public function test_delete_audio()
    {
        $this->loginAdmin();

        $response = $this->delete('/api/audios/11');
        $response->assertStatus(204);
    }

    public function test_delete_file()
    {
        $this->loginAdmin();

        $response = $this->delete('/api/files/11');
        $response->assertStatus(204);
    }
}
