<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ReplicationController As RepController;

class ReplicationController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $replicaSets = $client->replicationControllers()->find();
        foreach($replicaSets as $replicaSet) {
            dump($replicaSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->replicaSets()->exists('test-replication');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $replicationControllerSpec = new RepController([
            'apiVersion' => 'v1',
            'kind' => 'ReplicationController',
            'metadata' => [
                'name' => 'laravel-replicationcontroller',
                'labels' => [
                    'app' => 'laravel',
                ],
            ],
            'spec' => [
                'replicas' => 3,
                'selector' => [
                    'app' => 'laravel',
                ],
                'template' => [
                    'metadata' => [
                        'labels' => [
                            'app' => 'laravel',
                        ],
                    ],
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'laravelapp',
                                'image' => 'laravel_elastic_crash_laravelapp:latest',
                                'ports' => [
                                    [
                                        'containerPort' => 8000,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        
        $replica = $client->replicationControllers()->create($replicationControllerSpec);
        dump($replica);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $update = new RepController([
            'metadata' => [
                'name' => 'laravel-replicationcontroller',
                'labels' => [
                    'app' => 'laravel',
                ],
            ],
            'spec' => [
                'replicas' => 4,
                'selector' => [
                    'app' => 'laravel',
                ],
                'template' => [
                    'metadata' => [
                        'labels' => [
                            'app' => 'laravel',
                        ],
                    ],
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'laravelapp',
                                'image' => 'laravel_elastic_crash_laravelapp:old',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        
        $replicaSet = $client->replicationControllers()->patch($update);
        dump($replicaSet);
    }
}
