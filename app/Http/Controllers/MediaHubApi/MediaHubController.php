<?php

namespace App\Http\Controllers\MediaHubApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\SearchFormatter;
use App\Http\Requests\MediaHub\StoreMediaHubRequest;
use App\Http\Requests\MediaHub\StoreMediaHubFileRequest;
use App\Http\Requests\MediaHub\UpdateMediaHubRequest;
use App\Http\Resources\CollectionResource;
use App\Models\MediaHubAssets;

class MediaHubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', MediaHubAssets::class);
        $mediaHubAssets = SearchFormatter::getSearchQueries($request, MediaHubAssets::class);
        $mediaHubAssets = $mediaHubAssets->paginate($request->input('per_page'));

        return CollectionResource::make($mediaHubAssets);

        return $response->json();
    }

    public function show($id)
    {

        $mediaHubAssets = MediaHubAssets::findOrFail($id);

        return new CollectionResource($mediaHubAssets);

    }

    public function store(StoreMediaHubRequest $request)
    {

        $mediaHubAssets = MediaHubAssets::create($request->validated());

        return new CollectionResource($mediaHubAssets);
    }

    public function update(UpdateMediaHubRequest $request, $id)
    {
        $mediaHubAssets = MediaHubAssets::findOrFail($id);

        $mediaHubAssets->update();

        return new CollectionResource($mediaHubAssets);
    
    }

    public function destroy($id)
    {

        // Gate::authorize('delete', $feedback); 
        $mediaHubAssets = MediaHubAssets::findOrFail($id);

        $mediaHubAssets->delete();

        return response()->json([
            'message' => 'Asset deleted!'
        ]);
        
    }

    public function getAuthToken(){
       
        $client_id = env('CLIENT_ID');
        $secret = env('CLIENT_SCRET');

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
        ];

        $response = Http::withBasicAuth($client_id ,$secret)->asForm()->post(env('MEDIA_HUB_AUTH'),$data);

        return $response->json();
        
    }
    
}
