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
use App\Models\Product;
// use App\Models\Organisation;

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
        $this->CheckOrCreateOrganisation();
        $this->CheckOrCreateProduct($request->product_id);

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

    public function CheckOrCreateOrganisation() {

        $organisation = auth()->user()->organisation;
        $token =  $this->getAuthToken()['access_token'];
        $blnCheck = false;
        
        if($organisation->external_reference){
            $response = Http::withToken($token)->get(env('MEDIA_HUB_API').'/tenants/'. $organisation->external_reference);
        } else {
            $blnCheck = true;
        }
 
        if($blnCheck){
            $response = Http::withToken($token)->post(env('MEDIA_HUB_API') . '/tenants' , ['name' => $organisation->organisation_name]);
           
            if($response->successful()){
                // dd($response->json());
                    $organisation->external_reference = $response->json()['id'];
                    $organisation->save();
            } else {
                return $response->json();
            }
        } else {            
            return $response->json();
        }

    }

    public function CheckOrCreateProduct($id) {
        $product = Product::findOrFail($id);
        $token =  $this->getAuthToken()['access_token'];
        $blnCheck = false;
        
        if($product->external_reference){
            $response = Http::withToken($token)->get(env('MEDIA_HUB_API'). '/assets/' . $product->external_reference);
        } else {
            $blnCheck = true;
        }

        if($blnCheck){
         
            $data = [
                "description" => $product->synopsis,
                "externalReference" => $product->id,
                // "genres" => [
                //     $product->genres
                // ],
                // "poster" => "string",
                // "posterContentType" => "string",
                // "posterUrl" => "string",
                "tenant" => [
                "id" => $product->organisation->external_reference,
                "name" => $product->organisation->organisation_name,
                ],
                "title" => $product->title,
            ];
            
            $response = Http::withToken($token)->post(env('MEDIA_HUB_API'). '/assets/' , $data);

            if($response->successful()){
                $product->external_reference = $response->json()['id'];
                $product->save();
            } else {
                return $response->json();
            }
        }
    }
    
}
