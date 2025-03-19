<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Issuer;

class IssuerController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $issuers = $client->issuers()->find();
      
        foreach($issuers as $issuer) {
            dump($issuer->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->issuers()->exists('example-issuer');
        dump($exist);
    }
}
