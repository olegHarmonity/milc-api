<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        if(auth()->user()){
            $token =  $this->getAuthToken()['access_token'];
            $this->CheckOrCreateOrganisation();
            $aryGenres = [];
            foreach ($product->genres as $genres) {
                $aryGenres[] = $genres->name;
            }

            $data = [
                "description" => $product->synopsis,
                "externalReference" => $product->id,
                "genres" => $aryGenres,
                "tenant" => [
                    "id" => $product->organisation->external_reference,
                    "name" => $product->organisation->organisation_name,
                ],
                "title" => $product->title,
            ];

            $response = Http::withToken($token)->post(env('MEDIA_HUB_API') . '/assets/', $data);

            if ($response->successful()) {
                $product->external_reference = $response->json()['id'];
                $product->save();
            } else {
                return $response->json();
            }
        }
        
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    public function CheckOrCreateOrganisation()
    {

        $organisation = auth()->user()->organisation;
        $token =  $this->getAuthToken()['access_token'];
        $blnCheck = false;

        if ($organisation->external_reference) {
            $response = Http::withToken($token)->get(env('MEDIA_HUB_API') . '/tenants/' . $organisation->external_reference);

            if ($response->status() == 404) {
                $blnCheck = true;
            }
        } else {
            $blnCheck = true;
        }

        if ($blnCheck) {
            $response = Http::withToken($token)->post(env('MEDIA_HUB_API') . '/tenants', ['name' => $organisation->organisation_name]);

            if ($response->successful()) {
                $organisation->external_reference = $response->json()['id'];
                $organisation->save();
            } else {
                return $response->json();
            }
        } else {
            return $response->json();
        }
    }

    public function getAuthToken()
    {

        $client_id = env('CLIENT_ID');
        $secret = env('CLIENT_SCRET');

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id,
        ];

        $response = Http::withBasicAuth($client_id, $secret)->asForm()->post(env('MEDIA_HUB_AUTH'), $data);

        return $response->json();
    }
}
