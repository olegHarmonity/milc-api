<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateMovieRightRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieRight;
use Symfony\Component\HttpFoundation\Response;

class MovieRightController extends Controller
{
    public function index()
    {
        return new CollectionResource(MovieRight::all());
    }

    public function show(int $id)
    {
        return new Resource(MovieRight::find($id));
    }

    public function update(UpdateMovieRightRequest $request, int $id)
    {
        $movieRight = MovieRight::find($id);

        $movieRight->update($request->all());

        return (new Resource($movieRight))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieRightRequest $request)
    {
        $movieRight = MovieRight::create($request->all());

        return (new Resource($movieRight))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
