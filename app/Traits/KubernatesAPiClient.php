<?php

namespace App\Traits;

use GuzzleHttp\Client as GuzzleClient;
use Maclof\Kubernetes\Client;

trait KubernatesAPiClient
{
    /**
     * Initialize the Guzzle Client and the custom API Client.
     *
     * @return \SomeNamespace\Client  // Replace with your actual Client class
     */
    public function initializeApiClient()
    {
        $httpClient = new GuzzleClient([
            'verify' => false,
        ]);
        
        $client = new Client([
            'master' => 'https://172.30.49.52:6443',
            'token' => env('token')
        ], null, $httpClient);

        return $client;
    }
}
