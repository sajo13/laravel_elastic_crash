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

    public function create()
    {
        $client = $this->initializeApiClient();

        $job = new Ingress([
            'apiVersion' => 'networking.k8s.io/v1',
            'kind' => 'Ingress',
            'metadata' => [
                'name' => 'minimal-ingress',
                'annotations' => [
                    'nginx.ingress.kubernetes.io/rewrite-target' => '/',
                ],
            ],
            'spec' => [
                'ingressClassName' => 'nginx-example',
                'rules' => [
                    [
                        'http' => [
                            'paths' => [
                                [
                                    'path' => '/testpath',
                                    'pathType' => 'Prefix',
                                    'backend' => [
                                        'service' => [
                                            'name' => 'test',
                                            'port' => [
                                                'number' => 80,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $ingress = $client->ingresses()->create($job);
        dump($ingress);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $job = new Ingress([
            'metadata' => [
                'name' => 'minimal-ingress',
                'annotations' => [
                    'nginx.ingress.kubernetes.io/rewrite-target' => '/',
                ],
            ],
            'spec' => [
                'ingressClassName' => 'nginx-example',
                'rules' => [
                    [
                        'http' => [
                            'paths' => [
                                [
                                    'path' => '/testpath',
                                    'pathType' => 'Prefix',
                                    'backend' => [
                                        'service' => [
                                            'name' => 'test1',
                                            'port' => [
                                                'number' => 8080,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $ingress = $client->ingresses()->patch($job);
        dump($ingress);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'minimal-ingress';
        $endpoint = $client->ingresses()->find([ 'name' => $name]);
        
        $result = $client->ingresses()->delete($endpoint[0]);
        dump($result);
    }

    public function multiple()
    {
        $client = $this->initializeApiClient();

        $ingreesToUpdate = [
            [
                'name' => 'minimal-ingress',
                'ingressClassName' => 'nginx-test',
            ],
            [
                'name' => 'minimal-ingress2',
                'ingressClassName' => 'nginx-example2',
            ],

        ];

        foreach ($ingreesToUpdate as $ingressData) {
            $ingress = new Ingress([
                'metadata' => [
                    'name' => $ingressData['name'],
                ],
                'spec' => [
                    'ingressClassName' => $ingressData['ingressClassName'],
                ],
            ]);

            $ingress = $client->ingresses()->patch($ingress);
            dump($ingress);
        }
    }
}
