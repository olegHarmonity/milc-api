<?php

namespace App\Http\Controllers\Product;

use App\Helper\FileUploader;
use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateMovieGenreRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\MovieGenre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Product\MovieGenreResource;

class MovieGenreController extends Controller
{
    public function index(Request $request)
    {
        $movieGenres = SearchFormatter::getSearchQueries($request, MovieGenre::class);
        
        $movieGenres = $this->getMovieGenreResponseData($movieGenres)->get();
        
        return new CollectionResource($movieGenres);
    }

    public function show(int $id)
    {
        return new MovieGenreResource(MovieGenre::findOrFail($id));
    }

    public function update(UpdateMovieGenreRequest $request, MovieGenre $movieGenre)
    {
        Gate::authorize('update', $movieGenre);

        $movieGenreRequest = $request->all();
        
        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $movieGenreRequest['image_id'] = $image->id;
        }
        
        $movieGenre->update($movieGenreRequest);

        return new MovieGenreResource($movieGenre);
    }

    public function store(UpdateMovieGenreRequest $request)
    {
        Gate::authorize('create', MovieGenre::class);

        $movieGenreRequest = $request->all();
        
        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $movieGenreRequest['image_id'] = $image->id;
        }
        
        $movieGenre = MovieGenre::create($movieGenreRequest);
        
        return new MovieGenreResource($movieGenre);
    }
    
    public function destroy(MovieGenre $movieGenre)
    {
        Gate::authorize('delete', $movieGenre);
        
        $movieGenre->delete();
        
        return response("Successfully deleted!", Response::HTTP_NO_CONTENT);
    }
    
    private function getMovieGenreResponseData($person){
        
        $person = $person->with('image:id,image_name,image_url,mime,created_at,updated_at');
        
        $person = $person->select([
            'id',
            'name',
            'image_id',
            'number_of_clicks',
            'product_count'
        ]);
        
        return $person;
    }
}
