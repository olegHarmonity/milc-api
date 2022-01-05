<?php
namespace App\Observers;

use App\Models\Organisation;
use Illuminate\Support\Facades\Http;

class OrganisationObserver
{

    /**
     * Handle the Organisation "created" event.
     *
     * @param \App\Models\Organisation $organisation
     * @return void
     */
    public function created(Organisation $organisation)
    {
        $token = $this->getAuthToken();
        if (! $token) {
            return;
        }

        $token = $token['access_token'];

        $response = Http::withToken($token)->post(env('MEDIA_HUB_API') . '/tenants', [
            'name' => $organisation->organisation_name
        ]);

        if ($response->successful()) {
            $organisation->external_reference = $response->json()['id'];
            $organisation->save();
        } else {
            return $response->json();
        }
    }

    /**
     * Handle the Organisation "updated" event.
     *
     * @param \App\Models\Organisation $organisation
     * @return void
     */
    public function updated(Organisation $organisation)
    {
        //
    }

    public function getAuthToken()
    {
        $client_id = env('CLIENT_ID');
        $secret = env('CLIENT_SCRET');

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $client_id
        ];

        if ($client_id) {
            $response = Http::withBasicAuth($client_id, $secret)->asForm()->post(env('MEDIA_HUB_AUTH'), $data);
            return $response->json();
        }

        return null;
    }
}
