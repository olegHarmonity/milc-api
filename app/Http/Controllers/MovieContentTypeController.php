<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use App\Http\Requests\Product\UpdateMovieContentTypeRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieContentType;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Request;

class MovieContentTypeController extends Controller
{
    public function index(Request $request)
    {
        return new CollectionResource(SearchFormatter::getSearchResults($request, MovieContentType::class));
    }

    public function show(int $id)
    {
        return new Resource(MovieContentType::findOrFail($id));
    }

    public function update(UpdateMovieContentTypeRequest $request, MovieContentType $movieContentType)
    {
        Gate::authorize('update', $movieContentType);

        $movieContentType->update($request->all());

        return (new Resource($movieContentType))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieContentTypeRequest $request)
    {
        Gate::authorize('create', MovieContentType::class);

        $movieFormat = MovieContentType::create($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
