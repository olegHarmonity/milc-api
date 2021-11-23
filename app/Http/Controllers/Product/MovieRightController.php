<?php

namespace App\Http\Controllers\Product;

use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateMovieRightRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieRight;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class MovieRightController extends Controller
{
    public function index(Request $request)
    {
        return new CollectionResource(SearchFormatter::getPaginatedSearchResults($request, MovieRight::class));
    }

    public function show(int $id)
    {
        return new Resource(MovieRight::findOrFail($id));
    }

    public function update(UpdateMovieRightRequest $request, MovieRight $movieRight)
    {
        Gate::authorize('update', $movieRight);

        $movieRight->update($request->all());

        return (new Resource($movieRight))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieRightRequest $request)
    {
        Gate::authorize('create', MovieRight::class);

        $movieRight = MovieRight::create($request->all());

        return (new Resource($movieRight))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
    
    public function destroy(MovieRight $movieRight)
    {
        Gate::authorize('delete', $movieRight);
        
        $movieRight->delete();
        
        return response("Successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
