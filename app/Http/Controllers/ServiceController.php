<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Service;

class ServiceController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $services = $client->services()->find();
        foreach($services as $service) {
            dump($service->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->services()->exists('nginx-service');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $service = new Service([
            'apiVersion' => 'v1',
            'kind' => 'Service',
            'metadata' => [
                'name' => 'db-server',
            ],
            'spec' => [
                'selector' => [
                    'app' => 'mysql',
                ],
                'type' => 'ClusterIP',
                'ports' => [
                    [   
                        'name' => 'http',
                        'protocol' => 'TCP',
                        'port' => 3306,
                        'targetPort' => 3306,
                    ]
                ],
            ],
        ]);        
        
        $service = $client->services()->create($service);
        dump($service);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $service = new Service([
            'metadata' => [
                'name' => 'db-server',
            ],
            'spec' => [
                'selector' => [
                    'app' => 'mysql',
                ],
                'type' => 'ClusterIP',
                'ports' => [
                    [   
                        'name' => 'https',
                        'protocol' => 'TCP',
                        'port' => 3307,
                        'targetPort' => 3307,
                    ]
                ],
            ],
        ]);        
        
        $service = $client->services()->patch($service);
        dump($service);
    }
}
