<?php
namespace Tests\Feature\Product;

use Tests\ApiTestCase;
use Illuminate\Http\UploadedFile;
use App\Helper\SearchFormatter;
use phpDocumentor\Reflection\Types\This;

class ProductTest extends ApiTestCase
{

    public function test_post_movie_genres()
    {
        $this->loginAdmin();

        $data = [
            'name' => "new genre",
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true)
        ];

        $response = $this->post('/api/movie-genres', $data);

        $response->assertStatus(201);
    }

    public function test_get_products_by_category()
    {
        $response = $this->get('/api/products/by-category/1');
        $response->assertStatus(200);
    }

    public function test_get_movie_genres()
    {
        $response = $this->get('/api/movie-genres');

        $response->assertStatus(200);
    }

    public function test_get_movie_formats()
    {
        $response = $this->get('/api/movie-formats');
        $response->assertStatus(200);
    }

    public function test_get_movie_rights()
    {
        $response = $this->get('/api/movie-rights');
        $response->assertStatus(200);
    }

    public function test_post_person()
    {
        $this->loginAdmin();

        $data = [
            'first_name' => "name",
            'last_name' => "name",
            'image' => new UploadedFile(resource_path('test-files/image.png'), 'image.png', null, null, true)
        ];

        $response = $this->post('/api/persons', $data);
        $response->assertStatus(201);
    }

    public function test_delete_movie_genres()
    {
        $this->loginAdmin();
        $response = $this->delete('/api/movie-genres/11');
        $response->assertStatus(204);
    }

    public function test_get_movie_content_types()
    {
        $response = $this->get('/api/movie-content-types');
        $response->assertStatus(200);
    }

    public function test_get_products()
    {
        $response = $this->get('/api/products?sort[title]=desc');
        $response->assertStatus(200);
    }

    public function test_get_products_by_date()
    {
        $response = $this->get('/api/products?date[created_at]=2021-11-11&end_date[created_at]=2021-11-18');
        $response->assertStatus(200);
    }

    public function test_get_products_by_multiple_filters()
    {
        $response = $this->get('/api/products?exact_search[production_info.release_year][0]=2021&exact_search[production_info.release_year][1]=2020&exact_search[production_info.release_year][2]=2019');
        $response->assertStatus(200);
    }

    public function test_get_products_by_multiple_filters_2()
    {
        $response = $this->get('/api/products?exact_search[production_info.production_status][0]=released&exact_search[production_info.production_status][1]=unreleased&exact_search[genres.movie_genre_id]=3');
        $response->assertStatus(200);
    }

    public function test_get_products_by_genre_id()
    {
        $response = $this->get('/api/products?page=1&per_page=10&exact_search[genres.movie_genre_id]=2&start_date[created_at]=2017-09-03&end_date[created_at]=2022-07-08');
        $response->assertStatus(200);
    }

    public function test_get_products_by_genre_name()
    {
        $response = $this->get('/api/products?exact_search[genres.name]=Action&search[organisation_id]=1');
        $response->assertStatus(200);
    }

    public function test_get_products_by_organisation()
    {
        $response = $this->get('/api/products?search[organisation_id]=1');
        $response->assertStatus(200);
    }

    public function test_get_product()
    {
        $response = $this->get('/api/products/1');
        $response->assertStatus(200);
    }

    public function test_update_product_status()
    {
        $this->loginAdmin();
        $data = [
            'status' => 'inactive'
        ];

        $response = $this->put('/api/products/change-status/1', $data);
        $response->assertStatus(200);
    }

    public function test_create_product()
    {
        $this->loginCompanyAdmin();

        $data = [
            'title' => "Movie title",
            'alternative_title' => "Alternative movie title",
            'content_type_id' => 1,
            'movie_id' => 1,
            'screener_id' => 1,
            'trailer_id' => 1,
            'dub_files' => [
                1,
                2
            ],
            'subtitles' => [
                1,
                2
            ],
            'promotional_videos' => [
                1,
                2
            ],
            'runtime' => 127,
            'synopsis' => "A movie begins, has some story developments, and then ends.",
            'genres' => [
                2,
                4
            ],
            'available_formats' => [
                1,
                2
            ],
            'keywords' => [
                "key",
                "word"
            ],
            'original_language' => "en",
            'dubbing_languages' => [
                "English",
                "Russian"
            ],
            'subtitle_languages' => [
                "English",
                "Russian"
            ],
            'links' => [
                "link1" => "kli",
                "link2" => "kl22i"
            ],
            'allow_requests' => 1,
            'production_info' => [
                'release_year' => 2017,
                'production_year' => 2016,
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
                    ]
                ],
                'producers' => [
                    [
                        "first_name" => "first name4",
                        "last_name" => "last_name4"
                    ],
                    [
                        "first_name" => "first name5",
                        "last_name" => "last_name5"
                    ]
                ],
                'writers' => [
                    [
                        "first_name" => "first name6",
                        "last_name" => "last_name6"
                    ]
                ],
                'cast' => [
                    [
                        "first_name" => "first name7",
                        "last_name" => "last_name7"
                    ],
                    [
                        "first_name" => "first name8",
                        "last_name" => "last_name8"
                    ]
                ],
                'awards' => [
                    "award 1",
                    "award 2"
                ],
                'festivals' => [
                    "festival 1",
                    "festival 2"
                ],
                'box_office' => [
                    "1213 EUR",
                    "23787 EUR"
                ]
            ],
            'marketing_assets' => [
                'copyright_information' => "jdfjfdkkjf",
                'links' => [
                    "link 1",
                    "link 2"
                ]
            ],
            'rights_information' => [
                [
                    'title' => 'title',
                    'short_description' => 'short_description',
                    'long_description' => 'long_description', 
                    'available_from_date' => '2017-02-02',
                    'expiry_date' => '2030-02-02',
                    'available_rights' => [
                        1,
                        2
                    ],
                    'holdbacks' => "nothing's gonna hold us back!",
                    'territories' => [
                        "terr 1",
                        "terr 2"
                    ]
                ],
                [
                    'title' => 'title',
                    'short_description' => 'short_description',
                    'long_description' => 'long_description', 
                    'available_from_date' => '2018-02-02',
                    'expiry_date' => '2035-02-02',
                    'available_rights' => [
                        1,
                        2
                    ],
                    'holdbacks' => "nothing's gonna hold us back!2",
                    'territories' => [
                        "terr 12",
                        "terr 22"
                    ]
                ]
            ]
        ];

        $response = $this->post('/api/products', $data);
        $response->assertStatus(201);
    }

    public function test_create_empty_product()
    {
        $this->loginCompanyAdmin();

        $data = [
            'allow_requests' => 1,
            'title' => "Test",
            'alternative_title' => "test",
            'content_type_id' => 1,
            'movie_id' => 1,
            'screener_id' => 1,
            'trailer_id' => 1,
            'dub_files' => [
                1,
                2
            ],
            'subtitles' => [
                1,
                2
            ],
            'promotional_videos' => [
                1,
                2
            ],
            'runtime' => 120,
            'links' => [],
            'production_info' => [
                'box_office' => [],
                'production_status' => "released",
                'directors' => [],
                'producers' => [],
                'awards' => [
                    ""
                ],
                'writers' => [],
                'cast' => [],
                'festivals' => [
                    ""
                ],
                'release_year' => 2021,
                'production_year' => 2021,
                'country_of_origin' => "US"
            ],
            'marketing_assets' => [
                'copyright_information' => "test",
                'links' => [
                    ""
                ]
            ],
            'rights_information' => [],
            'original_language' => "en",
            'genres' => [
                1,
                2
            ],
            'available_formats' => [
                1,
                2
            ],

            'synopsis' => "test",
            'keywords' => [
                "test"
            ],
            'dubbing_languages' => [],
            'subtitle_languages' => []
        ];

        $response = $this->post('/api/products', $data);
        $response->assertStatus(201);
    }

    public function test_update_product()
    {
        $this->loginCompanyAdmin();

        $data = [
            'title' => "Movie title",
            'alternative_title' => "Alternative movie title",
            'content_type_id' => 2,
            'movie_id' => 1,
            'screener_id' => 1,
            'trailer_id' => 1,
            'dub_files' => [
                1,
                2
            ],
            'subtitles' => [
                1,
                2
            ],
            'runtime' => 127,
            'synopsis' => "A movie begins, has some story developments, and then ends.",
            'genres' => [
                2,
                4
            ],
            'available_formats' => [
                1,
                2
            ],
            'keywords' => [
                "key",
                "word"
            ],
            'original_language' => "en",
            'dubbing_languages' => [
                "English",
                "Russian"
            ],
            'subtitle_languages' => [
                "English",
                "Russian"
            ],
            'links' => [
                "link1" => "kli",
                "link2" => "kl22i"
            ],
            'allow_requests' => 1,
            'production_info' => [
                'id' => 1,
                'release_year' => 2017,
                'production_year' => 2016,
                'production_status' => "released",
                'country_of_origin' => "RO",
                'directors' => [
                    [
                        'id' => 1,
                        "first_name" => "first name1",
                        "last_name" => "last_name1"
                    ],
                    [
                        "first_name" => "first name2",
                        "last_name" => "last_name2"
                    ]
                ],
                'producers' => [
                    [
                        'id' => 1,
                        "first_name" => "first name4",
                        "last_name" => "last_name4"
                    ],
                    [
                        "first_name" => "first name5",
                        "last_name" => "last_name5"
                    ]
                ],
                'writers' => [
                    [
                        'id' => 1,
                        "first_name" => "first name6",
                        "last_name" => "last_name6"
                    ]
                ],
                'cast' => [
                    [
                        'id' => 1,
                        "first_name" => "first name7",
                        "last_name" => "last_name7"
                    ],
                    [
                        "first_name" => "first name8",
                        "last_name" => "last_name8"
                    ]
                ],
                'awards' => [
                    "award 1",
                    "award 2"
                ],
                'festivals' => [
                    "festival 1",
                    "festival 2"
                ],
                'box_office' => [
                    "1213 EUR",
                    "23787 EUR"
                ]
            ],
            'marketing_assets' => [
                'id' => 1,
                'copyright_information' => "jdfjfdkkjf",
                'links' => [
                    "link 1",
                    "link 2"
                ],
                'production_images' => [
                    3
                ],
                'key_artwork_id' => 1
            ],
            'rights_information' => [
                [
                    'id' => 1,
                    'title' => 'title',
                    'short_description' => 'short_description',
                    'long_description' => 'long_description', 
                    'available_from_date' => '2017-02-02',
                    'expiry_date' => '2030-02-02',
                    'available_rights' => [
                        1,
                        2
                    ],
                    'holdbacks' => "nothing's gonna hold us back!",
                    'territories' => [
                        "terr 1",
                        "terr 2"
                    ]
                ],
                [
                    'title' => 'title',
                    'short_description' => 'short_description',
                    'long_description' => 'long_description', 
                    'available_from_date' => '2018-02-02',
                    'expiry_date' => '2035-02-02',
                    'available_rights' => [
                        1,
                        2
                    ],
                    'holdbacks' => "nothing's gonna hold us back!2",
                    'territories' => [
                        "terr 12",
                        "terr 22"
                    ]
                ]
            ]
        ];

        $response = $this->put('/api/products/1', $data);
        // dump(($response));
        // dump(json_decode($response->getContent()));
        $response->assertStatus(200);
    }

    public function test_update_product_media()
    {
        $this->loginCompanyAdmin();

        $data = [
            'movie_id' => 1,
            'screener_id' => 1,
            'trailer_id' => 1,
            'dub_files' => [
                1,
                2
            ],
            'subtitles' => [
                1,
                2
            ],
            'marketing_assets' => [
                'id' => 1,
                'production_images' => [
                    3
                ],
                'key_artwork_id' => 1
            ]
        ];

        $response = $this->put('/api/products/1', $data);
        // dump(($response));
        // dump(json_decode($response->getContent()));
        $response->assertStatus(200);
    }

    public function test_get_persons()
    {
        $response = $this->get('/api/persons?search[full_name]=name name');
        $response->assertStatus(200);
    }

    public function test_delete_product()
    {
        $this->loginAdmin();

        $response = $this->delete('/api/products/1');
        $response->assertStatus(200);
    }
}
