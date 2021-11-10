<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateMovieFormatRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieFormat;
use Symfony\Component\HttpFoundation\Response;

class MovieFormatController extends Controller
{
    public function index()
    {
        return new CollectionResource(MovieFormat::all());
    }

    public function show(int $id)
    {
        return new Resource(MovieFormat::find($id));
    }

    public function update(UpdateMovieFormatRequest $request, int $id)
    {
        $movieFormat = MovieFormat::find($id);

        $movieFormat->update($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieFormatRequest $request)
    {
        $movieFormat = MovieFormat::create($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
