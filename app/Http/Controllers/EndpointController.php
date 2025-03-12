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
}
