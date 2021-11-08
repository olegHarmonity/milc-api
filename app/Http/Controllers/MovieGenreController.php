<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateMovieGenreRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieGenreController extends Controller
{
    public function index()
    {
        return new CollectionResource(MovieGenre::all());
    }

    public function show(int $id)
    {
        return new Resource(MovieGenre::find($id));
    }

    public function update(UpdateMovieGenreRequest $request, int $id)
    {
        $movieGenre = MovieGenre::find($id);

        $movieGenre->update($request->all());

        return (new Resource($movieGenre))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieGenreRequest $request)
    {
        $movieGenre = MovieGenre::create($request->all());

        return (new Resource($movieGenre))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
