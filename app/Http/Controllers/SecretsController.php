<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Secret;

class SecretsController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $secrets = $client->secrets()->find();
        foreach($secrets as $secret) {
            dump($secret->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->secrets()->exists('default-token-trplz');
        dump($exist);
    }
}
