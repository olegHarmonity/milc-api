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

        $response = Http::withToken($token)->get('https://milc-int.de/services/assets/api/assets');

        // get tenants
        // $response = Http::withToken($token)->get('https://milc-int.de/services/assets/api/_search/tenants?query=devla');

        return $response->json();
    }

    public function show(Request $request)
    {
        $token = $this->getAuthToken()['access_token'];

        $response = Http::withToken($token)->get('https://milc-int.de/services/assets/api/_search/items?query=tenant.name:wdw&page=0&size=20&sort=id.keyword,asc');
       

        return $response->json();
    }

    public function store(StoreMediaHubRequest $request)
    {

        $data = $request->validated();
        // $data = [
        //     "assetId" => "dasdasdasxzcxsdqw",
        //     "externalReference" => "sdxssdsa",
        //     "filename" => "dsadad.mp4",
        //     "metadata" => [
        //       "name" => "string",
        //       "type" => "string"
        //     ],
        //     "tenantName" => "devla",
        //     "type" => "video/mp4"
        // ];
        
        $token = $this->getAuthToken()['access_token'];

        $response = Http::withToken($token)->post('https://milc-int.de/services/assets/api/s3/multipart',$data);
       

        return $response->json();
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }

    public function getAuthToken(){
       
        $client_id = env('CLIENT_ID');
        $secret = env('CLIENT_SCRET');

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
        ];

        $response = Http::withBasicAuth($client_id ,$secret)->asForm()->post('https://milc-platform.auth.eu-central-1.amazoncognito.com/oauth2/token',$data);

        return $response->json();

    }
}
