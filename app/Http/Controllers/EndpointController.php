<?php

namespace App\Http\Controllers;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Endpoint;

use Illuminate\Http\Request;

class EndpointController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $endpoints = $client->endpoints()->find();
        dd($endpoints[1]);
        foreach($endpoints as $endpoint) {
            dump($endpoint->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->endpoints()->exists('nginx-service');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $endpoint = new Endpoint([
            'apiVersion' => 'v1',
            'kind' => 'Endpoints',
            'metadata' => [
                'name' => 'nginx-1-endpoint',
            ],
            'subsets' => [
                [
                    'addresses' => [
                        [ 'ip' => '10.0.0.1' ],
                        [ 'ip' => '10.0.0.2' ]
                    ],
                    'ports' => [
                        [ 'port' => 80 ]
                    ]
                ]
            ]
        ]);     
        
        $endpoint = $client->endpoints()->create($endpoint);
        dump($endpoint);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $endpoint = new Endpoint([
            'metadata' => [
                'name' => 'nginx-1-endpoint',
            ],
            'subsets' => [
                [
                    'addresses' => [
                        [ 'ip' => '10.0.0.3' ],
                        [ 'ip' => '10.0.0.4' ]
                    ],
                    'ports' => [
                        [ 'port' => 81 ]
                    ]
                ]
            ]
        ]);     
        
        $endpoint = $client->endpoints()->patch($endpoint);
        dump($endpoint);
    }
}
