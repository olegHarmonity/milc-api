<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use App\Http\Requests\Product\UpdateMovieGenreRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieGenre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class MovieGenreController extends Controller
{
    public function index(Request $request)
    {
        return new CollectionResource(SearchFormatter::getSearchResults($request, MovieGenre::class));
    }

    public function show(int $id)
    {
        return new Resource(MovieGenre::findOrFail($id));
    }

    public function update(UpdateMovieGenreRequest $request, MovieGenre $movieGenre)
    {
        Gate::authorize('update', $movieGenre);

        $movieGenre->update($request->all());

        return (new Resource($movieGenre))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieGenreRequest $request)
    {
        Gate::authorize('create', MovieGenre::class);

        $movieGenre = MovieGenre::create($request->all());

        return (new Resource($movieGenre))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
