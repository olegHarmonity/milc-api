<?php

namespace App\Http\Controllers\MediaHubApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\MediaHub\StoreMediaHubRequest;

class MediaHubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = $this->getAuthToken()['access_token'];

        $response = Http::withToken($token)->get(env('MEDIA_HUB_API').'/assets');

        return $response->json();
    }

    public function show($id)
    {
        $token = $this->getAuthToken()['access_token'];

        $response = Http::withToken($token)->get(env('MEDIA_HUB_API').'/assets/'. $id);

        return $response->json();
    }

    public function store(StoreMediaHubRequest $request)
    {

        $data = $request->validated();
          
        $data['tenant'] = [
            "id" => "61a87c9aa3cb5219570f5e96",
            "name" => "DEVLA" 
        ];

        // dd($data);
        
        $token = $this->getAuthToken()['access_token'];

        $url = env('MEDIA_HUB_API');

        $response = Http::withToken($token)->post(env('MEDIA_HUB_API').'/assets', $data);

        return $response->json();
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {

        dd($id);
        $token = $this->getAuthToken()['access_token'];

        $response = Http::withToken($token)->delete(env('MEDIA_HUB_API').'/assets/'. $id);

        return $response->json();
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
