<?php

namespace App\Providers;

use App\Models\Audio;
use App\Models\File;
use App\Models\Image;
use App\Models\MovieContentType;
use App\Models\MovieFormat;
use App\Models\MovieGenre;
use App\Models\MovieRight;
use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\Person;
use App\Models\Product;
use App\Models\User;
use App\Models\Video;
use App\Models\Feedback;
use App\Policies\AudioPolicy;
use App\Policies\FilePolicy;
use App\Policies\ImagePolicy;
use App\Policies\MovieContentTypePolicy;
use App\Policies\MovieFormatPolicy;
use App\Policies\MovieGenrePolicy;
use App\Policies\MovieRightPolicy;
use App\Policies\OrganisationPolicy;
use App\Policies\OrganisationTypePolicy;
use App\Policies\PersonPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Policies\VideoPolicy;
use App\Policies\FeedbackPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Organisation::class => OrganisationPolicy::class,
        OrganisationType::class => OrganisationTypePolicy::class,
        Image::class => ImagePolicy::class,
        File::class => FilePolicy::class,
        Audio::class => AudioPolicy::class,
        Video::class => VideoPolicy::class,
        Product::class => ProductPolicy::class,
        MovieContentType::class => MovieContentTypePolicy::class,
        MovieFormat::class => MovieFormatPolicy::class,
        MovieGenre::class => MovieGenrePolicy::class,
        MovieRight::class => MovieRightPolicy::class,
        Person::class => PersonPolicy::class,
        Feedback::class => FeedbackPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
