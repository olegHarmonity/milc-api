<?php

namespace Tests\Feature\Product;

use Tests\ApiTestCase;

class ProductTest extends ApiTestCase
{
    public function test_get_movie_genres()
    {
        $response = $this->get('/api/movie-genres');
        $response
            ->assertStatus(200);
    }

    public function test_get_movie_formats()
    {
        $response = $this->get('/api/movie-formats');
        $response
            ->assertStatus(200);
    }

    public function test_get_persons()
    {
        $response = $this->get('/api/persons');
        $response
            ->assertStatus(200);
    }

    public function test_get_movie_rights()
    {
        $response = $this->get('/api/movie-rights');
        $response
            ->assertStatus(200);
    }

    public function test_get_products()
    {
        $response = $this->get('/api/products');
        $response
            ->assertStatus(200);
    }

     public function test_get_product()
     {
         $response = $this->get('/api/products/1');
         $response
             ->assertStatus(200);
     }

    public function test_create_product()
    {
        $this->loginCompanyAdmin();

        $data = [
            'title' => "Movie title",
            'alternative_title' => "Alternative movie title",
            'content_type' => "Type of content",
            'runtime' => 127,
            'synopsis' => "A movie begins, has some story developments, and then ends.",
            'genres' => [2, 4],
            'available_formats' => [1, 2],
            'keywords' => ["key", "word"],
            'original_language' => "en",
            'dubbing_languages' => ["English", "Russian"],
            'subtitle_languages' => ["English", "Russian"],
            'links' => ["link1" => "kli", "link2" => "kl22i"],
            'allow_requests' => 1,
            'production_info' => [
                'release_year' => '2017-01-01',
                'production_year' => '2016-01-01',
                'production_status' => "released",
                'country_of_origin' => "RO",
                'directors' => [
                    [
                        "first_name" => "first name1",
                        "last_name" => "last_name1"
                    ],
                    [
                        "first_name" => "first name2",
                        "last_name" => "last_name2"
                    ],
                    [
                        "first_name" => "first name3",
                        "last_name" => "last_name3"
                    ]],
                'producers' => [
                    [
                        "first_name" => "first name4",
                        "last_name" => "last_name4"
                    ],
                    [
                        "first_name" => "first name5",
                        "last_name" => "last_name5"
                    ]],
                'writers' => [
                    [
                        "first_name" => "first name6",
                        "last_name" => "last_name6"
                    ],],
                'cast' => [
                    [
                        "first_name" => "first name7",
                        "last_name" => "last_name7"
                    ],
                    [
                        "first_name" => "first name8",
                        "last_name" => "last_name8"
                    ],],
                'awards' => ["award 1", "award 2"],
                'festivals' => ["festival 1", "festival 2"],
                'box_office' => ["1213 EUR", "23787 EUR"],
            ],
            'marketing_assets' => [
                'copyright_information' => "jdfjfdkkjf",
                'links' => ["link 1", "link 2"],
            ],
            'rights_information' => [
                [
                    'available_from_date' => '2017-02-02',
                    'expiry_date' => '2030-02-02',
                    'available_rights' => [1, 2],
                    'holdbacks' => "nothing's gonna hold us back!",
                    'territories' => ["terr 1", "terr 2"],
                ],
                [
                    'available_from_date' => '2018-02-02',
                    'expiry_date' => '2035-02-02',
                    'available_rights' => [1, 2],
                    'holdbacks' => "nothing's gonna hold us back!2",
                    'territories' => ["terr 12", "terr 22"],
                ],
            ],
        ];

        $response = $this->post('/api/products', $data);
        dump(json_decode($response->getContent()));
        $response->assertStatus(201);
    }
}
