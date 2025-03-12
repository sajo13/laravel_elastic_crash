<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ServiceAccount;

class ServiceaccountController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $serviceAccounts = $client->serviceAccounts()->find();
      
        foreach($serviceAccounts as $serviceAccount) {
            dump($serviceAccount->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->serviceAccounts()->exists('my-service-account');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $endpoint = new ServiceAccount([
            'apiVersion' => 'v1',
            'kind' => 'ServiceAccount',
            'metadata' => [
                'annotations' => [
                    'kubernetes.io/enforce-mountable-secrets' => "true"
                ],
                'name' => 'my-serviceaccount',
                'namespace' => 'default'
            ],
        ]);     
        
        $endpoint = $client->serviceAccounts()->create($endpoint);
        dump($endpoint);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $endpoint = new ServiceAccount([
            'metadata' => [
                'annotations' => [
                    'kubernetes.io/enforce-mountable-secrets' => "false"
                ],
                'name' => 'my-serviceaccount',
                'namespace' => 'default'
            ],
        ]);     
        
        $endpoint = $client->serviceAccounts()->patch($endpoint);
        dump($endpoint);
    }
}
