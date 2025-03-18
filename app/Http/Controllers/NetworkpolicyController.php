<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\NetworkPolicy;

class NetworkpolicyController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $networkPolicies = $client->networkPolicies()->find();
      
        foreach($networkPolicies as $networkPolicie) {
            dump($networkPolicie->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->networkPolicies()->exists('example-policy');
        dump($exist);
    }
}
