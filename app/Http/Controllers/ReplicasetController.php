<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ReplicaSet;

class ReplicasetController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $replicaSets = $client->replicaSets()->find();
        foreach($replicaSets as $replicaSet) {
            dump($replicaSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->replicaSets()->exists('nginx-deployment-585449566');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $replicaSetSpec = new ReplicaSet([
            'apiVersion' => 'apps/v1',
            'kind' => 'ReplicaSet',
            'metadata' => [
                'name' => 'laravel-replicaset',
                'labels' => [
                    'app' => 'laravel',
                ],
            ],
            'spec' => [
                'replicas' => 3,
                'selector' => [
                    'matchLabels' => [
                        'app' => 'laravel',
                    ],
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
        
        $replicaSet = $client->replicaSets()->create($replicaSetSpec);
        dump($replicaSet);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $replicaSetSpec = new ReplicaSet([
            'metadata' => [
                'name' => 'laravel-replicaset',
                'labels' => [
                    'app' => 'laravel',
                ],
            ],
            'spec' => [
                'replicas' => 4,
                'selector' => [
                    'matchLabels' => [
                        'app' => 'laravel',
                    ],
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
        
        $replicaSet = $client->replicaSets()->patch($replicaSetSpec);
        dump($replicaSet);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'laravel-replicaset';
        $namespaceModel = $client->replicaSets()->find([ 'name' => $name]);
        $namespace = $client->replicaSets()->delete($namespaceModel[1]);
        dump($namespace['status']);
    }
}
