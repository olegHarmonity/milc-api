<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateMovieContentTypeRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieContentType;
use Symfony\Component\HttpFoundation\Response;

class MovieContentTypeController extends Controller
{
    public function index()
    {
        return new CollectionResource(MovieContentType::all());
    }

    public function show(int $id)
    {
        return new Resource(MovieContentType::find($id));
    }

    public function update(UpdateMovieContentTypeRequest $request, int $id)
    {
        $organisation = MovieContentType::find($id);

        $organisation->update($request->all());

        return (new Resource($organisation))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieContentTypeRequest $request)
    {
        $movieFormat = MovieContentType::create($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
