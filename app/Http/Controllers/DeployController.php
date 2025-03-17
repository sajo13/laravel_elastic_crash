<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Deployment;

class DeployController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $deployments = $client->deployments()->find();
      
        foreach($deployments as $deployment) {
            dump($deployment->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->deployments()->exists('ngnix-deployment');
   
        dump($exist);
    }
}
