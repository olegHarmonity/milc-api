<?php

namespace App\Http\Controllers\Product;

use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateMovieFormatRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieFormat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class MovieFormatController extends Controller
{
    public function index(Request $request)
    {
        return new CollectionResource(SearchFormatter::getPaginatedSearchResults($request, MovieFormat::class));
    }

    public function show(int $id)
    {
        return new Resource(MovieFormat::findOrFail($id));
    }

    public function update(UpdateMovieFormatRequest $request, MovieFormat $movieFormat)
    {
        Gate::authorize('update', $movieFormat);

        $movieFormat->update($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(UpdateMovieFormatRequest $request)
    {
        Gate::authorize('create', MovieFormat::class);

        $movieFormat = MovieFormat::create($request->all());

        return (new Resource($movieFormat))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
    
    
    public function destroy(MovieFormat $movieFormat)
    {
        Gate::authorize('delete', $movieFormat);
        
        $movieFormat->delete();
        
        return response("Successfully deleted!", Response::HTTP_NO_CONTENT);
    }
}
