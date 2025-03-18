<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Ingress;

class IngressController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $ingresses = $client->ingresses()->find();
      
        foreach($ingresses as $ingress) {
            dump($ingress->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->ingresses()->exists('example-ingress');
        dump($exist);
    }
}
